<?php

namespace App\Http\Controllers\HRIS;

use App\Http\Controllers\Controller;
use App\Models\HRIS\Role;
use App\Models\HRIS\RoleUser;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $role;
    protected $permission;
    protected $roleUser;
    protected $userPermission;
    protected $user;

    public function __construct(Role $role, Permission $permission, RoleUser $roleUser, UserPermission $userPermission, User $user)
    {
        $this->role = $role;
        $this->permission = $permission;
        $this->roleUser = $roleUser;
        $this->userPermission = $userPermission;
        $this->user =  $user;
    }

    public function index()
    {
        $roles = $this->role->where('company_id', auth()->user()->company_id)->where('status', 'Active')->get();
        return view('backend.hris.user.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = User::select('users.*', 'role_id')
                    ->join('role_users', 'users.id', 'role_users.user_id')
                    ->where('users.id', $request->user_id)
                    ->where('users.company_id', auth()->user()->company_id)
                    ->first();
                // $data = User::findOrFail($request->user_id);
                return response()->json(['status' => true, 'data' => $data], 200);
            } catch (Exception $ex) {
                return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            try {
                $data = User::findOrFail($request->id);
                $data->update($request->all());
                $roleUser = $this->roleUser->where('user_id', $request->id)->where('company_id', auth()->user()->company_id)->firstOrFail();
                $roleUser->role_id = $request->role_id;
                $roleUser->save();
                return response()->json(['status' => true, 'message' => 'User Updated Successfully'], 200);
            } catch (Exception $ex) {
                return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list(Request $request)
    {
        // return response()->json(['data'=>'abc']);
        // dd('testing');


        return DataTables::of(User::getAllUsers())
            ->addIndexColumn()
            ->addColumn('action', function ($model) {
                $action = auth()->user()->company_id && permission('hris.user.edit') ? '<i class="fas fa-edit custom_edit" data-id="' . $model->id . '">' : "";
                $action .= permission('hris.user.permission') ? '</i> <a href="' . route('hris.user.permission', $model->id) . '">Special Permission</a>' : "";
                return $action;
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }

    public function userPermission($user_id)
    {
        $user = $this->user->findOrFail($user_id);
        $userRole = $this->roleUser->getRoleByUserIdAndCompanyId($user_id, $user->company_id);
        $rolePermissions = [];
        if ($userRole) {
            $role = $this->role->findOrFail($userRole->role_id);
            $rolePermissions = json_decode($role->permission, true);
        }

        $groupPermissions = getCompanyPermissions();
        $userPermission = $this->userPermission->where('user_id', $user_id)->first();
        $userPermission = $userPermission ? json_decode($userPermission->permissions, true) : [];

        return view('backend.hris.user.permission', compact('groupPermissions', 'rolePermissions', 'role', 'user_id','userPermission'));
    }

    public function userPermissionPost(Request $request, $user_id)
    {
        // dd($request->all());
        $user = $this->user->findOrFail($user_id);
        $user->update(['user_type' => 'SUPER EMPLOYEE']);

        $permissions = [];
        if ($request->permissions)
            foreach ($request->permissions as $permission) {
                $permissions[] = $permission;
            }
        $userPermission = $this->userPermission->where('user_id', $user_id)->first();
        if ($userPermission) {
            $userPermission->permissions = json_encode($permissions);
            $userPermission->save();
        } else {
            $this->userPermission->create(['user_id' => $user_id, 'company_id' => auth()->user()->company_id, 'permissions' => json_encode($permissions)]);
        }

        return redirect()->route('hris.user.index')->with('success', 'User Permission Setted Successfully.');
    }
}
