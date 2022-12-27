<?php

namespace App\Service\User;

use App\Models\LineManager\LineManager;
use App\Models\User;
use App\Models\Leave\UserLeaveEntitlements\UserLeaveEntitlements;
use App\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserService extends Service
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->user->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('is_active',function(user $user) {
                if($user->is_active == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('status',function(user $user) {
                if($user->status == '1'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(user $user) {
                if(isset($user->image_path)){
                    return '<img src="http://127.0.0.1:8000/'.($user->image_path).'" width="100px">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(user $user) {
                $editRoute =  route('user.edit',$user->id);
                $deleteRoute =  route('user.destroy',$user->id);
                return getTableHtml($user,'actions',$editRoute,$deleteRoute);
                return getTableHtml($user,'image');
            })->rawColumns(['visibility','is_active','status','image'])->make(true);
    }

    public function getUserUnderManager()
    {
        $query = "select name,line_manager_id, count(line_manager_id) as total
                    FROM line_managers lm
                    join users u
                      on lm.line_manager_id = u.id
                    GROUP by name,line_manager_id";

        return DB::select($query);
    }

    /*For Manager Table*/
    public function getManagerData()
    {
        $query = $this->getUserUnderManager();

        return DataTables::of($query)
            ->editcolumn('actions',function($query) {
                $editRoute =  route('linemanager.edit', $query->line_manager_id);
                $deleteRoute =  route('linemanager.destroy', $query->line_manager_id);
                return getTableHtml($query,'actions',$editRoute, $deleteRoute);
            })->make(true);
    }

    /*For Entitlement Table*/
    public function entitlementData()
    {
        $user_id_entitlements = UserLeaveEntitlements::select('user_id')->distinct()->get();
        $query = $this->user->whereIsDeleted('no')->whereIn('id',$user_id_entitlements)->get();
        // $query = $this->user::whereIsDeleted('no')->join('user_leave_entitlements','user_leave_entitlements.user_id','users.id')->get();


        return DataTables::of($query)
            ->addIndexColumn()
            ->editcolumn('entitlements',function($query) {
                $userentitlements = $query->userentitlements;
                $html = "";
                foreach($userentitlements as $userentitlement) {

                    $html .=$userentitlement->leavetype->name. " : " .$userentitlement->total_days."<br>";
                }
                return $html;

            })
            ->editcolumn('actions',function($query) {
                $editRoute =  route('entitlement.edit',$query->id);
                $deleteRoute =  route('entitlement.destroy', $query->id);
                return getTableHtml($query,'actions',$editRoute, $deleteRoute);
            })->rawColumns(['entitlements','is_active','status','image'])->make(true);
    }

    public function create(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/
            $data['password'] = Hash::make($data['password']);
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? '1' : '0';
            $data['is_active'] = (isset($data['is_active']) ?  $data['is_active'] : '')=='on' ? 'active' : 'in_active';
            $data['created_by']= Auth::user()->id;

            //dd($data);
            $user = $this->user->create($data);
            return $user;

        } catch (Exception $e) {
            return null;
        }
    }

    public function lineManagerCreate(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/

            foreach($data['user_id'] as $userid) {
                $user= $this->user->find($userid);
                $data['line_manager'] = $data['line_manager'];
                $user = $user->update($data);
            }

            return $user;
        } catch (Exception $e) {
            return null;
        }
    }

    public function entitlementCreate(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/

            $userleavedetails = UserLeaveEntitlements::where('user_id', $data['user_id'])->get();
            foreach ($userleavedetails as $userleavedetail) {
                $userleavedetail->delete();
            }
            if(isset($data['total_days'])){
                $p = 0;
                foreach ($data['total_days'] as $leavedata) {
                    if(isset($leavedata)) {
                        $userleaveentitlements = new UserLeaveEntitlements();
                        $userleaveentitlements->user_id = $data['user_id'];
                        $userleaveentitlements->leave_type = $data['leave_type'][$p];
                        $userleaveentitlements->total_days = $leavedata;
                        $userleaveentitlements->created_by = Auth::user()->id;
                        $userleaveentitlements->updated_by = Auth::user()->id;
                        $userleaveentitlements->save();
                        $p = $p + 1;
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * Paginate all User
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;

        return $this->user->orderBy('id','DESC')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->user->whereIsDeleted('no')->get();
    }

    public function linemanageruser()
    {
        return $this->user->whereIsDeleted('no')->where('line_manager',null)->get();
    }

    public function userslinemanager($id)
    {
        return $this->user->whereIsDeleted('no')->where('line_manager',$id)->get();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($userId)
    {
        try {
            return $this->user->whereIsDeleted('no')->find($userId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($userId, array $data)
    {
        try {
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? '1' : '0';
            $data['is_active'] = (isset($data['is_active']) ?  $data['is_active'] : '')=='on' ? 'active' : 'in_active';
            $data['has_subuser'] = (isset($data['has_subuser']) ?  $data['has_subuser'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $user= $this->user->find($userId);

            $user = $user->update($data);
            //$this->logger->info(' created successfully', $data);

            return $user;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function updatelinemanager($id,array $data) {
        try {
            $user = null;
            $allusers = $this->user->where('line_manager',$id)->get();
            foreach($allusers as $alluserdata) {
                $data['line_manager'] = null;
                $user = $alluserdata->update($data);
            }
            if(isset($data['user_id'])) {
                foreach($data['user_id'] as $userid) {

                    $user= $this->user->find($userid);
                    $data['line_manager'] = $id;
                    $user = $user->update($data);
                }
            }

            return $user;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function updateuserentitlement($id,array $data) {
        try {
            $userleavedetails = UserLeaveEntitlements::where('user_id', $id)->get();
            foreach ($userleavedetails as $userleavedetail) {
                $userleavedetail->delete();
            }
            if(isset($data['total_days'])){
                $p = 0;
                foreach ($data['total_days'] as $leavedata) {
                    if(isset($leavedata)) {
                        $userleaveentitlements = new UserLeaveEntitlements();
                        $userleaveentitlements->user_id = $id;
                        $userleaveentitlements->leave_type = $data['leave_type'][$p];
                        $userleaveentitlements->total_days = $leavedata;
                        $userleaveentitlements->created_by = Auth::user()->id;
                        $userleaveentitlements->updated_by = Auth::user()->id;
                        $userleaveentitlements->save();
                        $p = $p + 1;
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }


    /**
     * Delete a User
     *
     * @param Id
     * @return bool
     */
    public function delete($userId)
    {
        try {
            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $user = $this->user->find($userId);
            $data['is_deleted']='yes';
            $data['status']='0';
            $data['is_active']='in_active';
            return $user = $user->update($data);

        } catch (Exception $e) {
            return false;
        }
    }

    public function entitlementdelete($userId)
    {
        try {
            UserLeaveEntitlements::where('user_id', $userId)->delete();

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function getUserRoles($id){
        try{
            $user = User::with('roles')->find($id);
            $roles = $user->roles;
            return $roles;
        }catch (Exception $e){
            return false;
        }
    }

    public function getUserPermission($id){
        try{

            $user = User::with('permissions')->find($id);
            $permissions = $user->permissions;
            return $permissions;
        }catch (Exception $e){
            return false;
        }
    }


    /**
     * write brief description
     * @param $name
     * @return mixed
     */
    public function getByName($name){
        return $this->user->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($id){
        return $this->user->whereIsDeleted('no')->whereId($id)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/user';
            return $fileName = $this->uploadFromAjax($file);
        }
    }

    public function __deleteImages($subCat)
    {
        try {
            if (is_file($subCat->image_path))
                unlink($subCat->image_path);

            if (is_file($subCat->thumbnail_path))
                unlink($subCat->thumbnail_path);
        } catch (\Exception $e) {

        }
    }

    public function updateImage($userId, array $data)
    {
        try {
            $user = $this->user->find($userId);
            $user = $user->update($data);

            return $user;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function getUsersForLineManager(){
        $managers = LineManager::select('line_manager_id')
                                ->groupBy('line_manager_id')
                                ->get()
                                ->pluck('line_manager_id');

        return $this->user->whereNotIn('id', $managers)->orderBy('name')->get();
    }

    public function getUsersForEntitlement(){
        $users = UserLeaveEntitlements::select('user_id')
            ->groupBy('user_id')
            ->get()
            ->pluck('user_id');

        return $this->user->whereNotIn('id', $users)->orderBy('name')->get();
    }
}
