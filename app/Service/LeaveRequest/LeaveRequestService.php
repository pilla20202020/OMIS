<?php

namespace App\Service\LeaveRequest;

use App\Models\Leave\Holiday\Holiday;
use App\Models\Leave\LeaveRequest\LeaveRequest;
use App\Models\Leave\LeaveTypes\LeaveTypes;
use App\Models\User;
use App\Service\Service;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class LeaveRequestService extends Service
{
    protected $leaverequest,$user,$leavetype;

    public function __construct(LeaveRequest $leaverequest,User $user,LeaveTypes $leavetype,Holiday $holidays)
    {
        $this->leaverequest = $leaverequest;
        $this->user = $user;
        $this->holidays = $holidays;
        $this->leavetype = $leavetype;

    }


    /*For Request List DataTable*/
    public function getAllData()
    {
        $query = $this->leaverequest->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('user_id',function(LeaveRequest $leaverequest) {
                if($leaverequest->user->first_name) {
                    return $leaverequest->user->first_name.' '.$leaverequest->user->last_name;
                }
            })
            ->editColumn('leave_type',function(LeaveRequest $leaverequest) {
                if($leaverequest->leavetype->name) {
                    return $leaverequest->leavetype->name;
                }
            })
            ->editColumn('approved_by',function(LeaveRequest $leaverequest) {
                if($leaverequest->status_user){
                    return (ucfirst($leaverequest->statusUser->name));
                }
            })
            ->editColumn('is_approved',function(LeaveRequest $leaverequest) {
                if($leaverequest->status == "1"){
                    return '<span class="badge badge-primary"> Approved </span>';
                }
                elseif($leaverequest->status == "0") {
                    return "<span class='badge badge-danger'>Rejected</span>";
                }
                else {
                    return "<span class='badge badge-warning'>Pending</span>";
                }
            })
            ->editcolumn('actions',function(LeaveRequest $leaverequest) {
                if(auth()->user()->user_type == "SUPER ADMIN"){
                    if($leaverequest->status == "1"){
                        $deleteRoute = null;
                    }
                    elseif($leaverequest->status == "0") {
                        $deleteRoute = null;
                    }
                    else {
                    return '<a  href="' . route('leaverequest.destroy',$leaverequest->id) . '"><i class="fas fa-trash" data-id=""></i></a>';
                    }
                } else {
                    $deleteRoute = null;
                }
                return '<a  href="' . route('leaverequest.show',$leaverequest->id) . '"><i class="fas fa-eye" data-id=""></i></a>';
                $viewRoute =  route('leaverequest.show',$leaverequest->id);
            })->rawColumns(['is_approved','actions'])->make(true);
    }

    /*For User Request List DataTable*/
    public function getAllUserData()
    {
        $query = $this->leaverequest->where('user_id',auth()->user()->id)->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('user_id',function(LeaveRequest $leaverequest) {
                if($leaverequest->user->first_name) {
                    return $leaverequest->user->first_name.' '.$leaverequest->user->last_name;
                }
            })
            ->editColumn('leave_type',function(LeaveRequest $leaverequest) {
                if($leaverequest->leavetype->name) {
                    return $leaverequest->leavetype->name;
                }
            })
            ->editColumn('approved_by',function(LeaveRequest $leaverequest) {
                if($leaverequest->status_user){
                    return (ucfirst($leaverequest->statusUser->name));
                }
            })
            ->editColumn('is_approved',function(LeaveRequest $leaverequest) {
                if($leaverequest->status == "1"){
                    return '<span class="badge badge-primary"> Approved </span>';
                }
                elseif($leaverequest->status == "0") {
                    return "<span class='badge badge-danger'>Rejected</span>";
                }
                else {
                    return "<span class='badge badge-warning'>Pending</span>";
                }
            })
            ->editcolumn('actions',function(LeaveRequest $leaverequest) {
                if($leaverequest->status == "1"){
                    $deleteRoute = null;
                }
                elseif($leaverequest->status == "0") {
                    $deleteRoute = null;
                }
                else {
                    $deleteRoute =  route('leaverequest.destroy',$leaverequest->id);
                }

                $viewRoute =  route('leaverequest.show',$leaverequest->id);
                return getTableHtml($leaverequest,'actions',$editRoute = null,$deleteRoute,$viewRoute,$printRoute = null);
            })->rawColumns(['is_approved'])->make(true);
    }

    public function getAllLeaveRequestsForCalendar()
    {
        $query = $this->leaverequest->where('status',1)->orderBy('start_date')->get();
        return $query;
    }

    /*For Request List of User DataTable for Dashboard Controller*/
    public function getAllLeaveRequestOfUser()
    {
        $query = $this->leaverequest->where('user_id',auth()->user()->id)->orderBy('start_date')->get();

        return $query;
    }

    public function getRecentLeaveRequestOfUser()
    {
        $query = $this->leaverequest->where('user_id',auth()->user()->id)->orderBy('start_date', 'DESC')->limit(5)->get();

        return $query;
    }

    /*For Calendar for Dashboard Controller*/
    public function getAllLeaveRequestOfUserForCalendar()
    {
        $query = $this->leaverequest->where('user_id',auth()->user()->id)->where('status',1)->orderBy('start_date')->get();
        return $query;
    }

    /*For Request List of User DataTable for Dashboard Controller*/
    public function getUpComingLeaveRequestOfUser()
    {
        $query = $this->leaverequest->where('user_id',auth()->user()->id)->where('status','!=',0)->whereDate('start_date', '>', Carbon::now())->orderBy('start_date')->take(1)->get();
        return $query;
    }

    public function create(array $data)
    {
        try {
            $startdate = new DateTime($data['start_date']);
            $enddate = new DateTime($data['end_date']);
            $enddate->modify('+1 day');
            $interval = $enddate->diff($startdate);

            $days = $interval->days;
            // dd($startdate,$enddate);

            $period = new DatePeriod($startdate, new DateInterval('P1D'), $enddate);

            $holidays = $this->holidays->all();
            if(isset($holidays)) {
                foreach($holidays as $holidaydata) {
                    $holiday = array($holidaydata->date);
                }
            }


            foreach($period as $dt) {
                $curr = $dt->format('D');

                // substract if Saturday or Sunday
                if ($curr == 'Sat' || $curr == 'Sun') {
                    $days--;
                }

                elseif (isset($holiday) && in_array($dt->format('Y-m-d'), $holiday)) {
                    $days--;
                }

            }
            if($data['type'] == "half") {
                $days = $days/2;
            } else {
                $days = $days;
            }
            $data['sub_total'] = $days;

            $data['created_by']= Auth::user()->id;
            if(isset($data['user_id'])) {
                $data['user_id'] = $data['user_id'];
            } else {
                $data['user_id']= Auth::user()->id;
            }
            $data['date']= Carbon::now();
            $leaverequest = $this->leaverequest->create($data);
            return $leaverequest;

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

        return $this->leaverequest->orderBy('id','DESC')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function getSubTotal()
    {
        $auth = auth()->user()->id;
        return DB::select("SELECT user_id,name,sum(sub_total) as sub_total FROM (SELECT l.user_id,l.sub_total,lt.name FROM leave_requests l INNER JOIN leave_types lt on l.leave_type = lt.id AND l.status = 1 AND l.user_id = $auth) as tt GROUP BY user_id,name");
    }



    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($leaverequestId)
    {
        try {
            return $this->leaverequest->find($leaverequestId);
        } catch (Exception $e) {
            return null;
        }
    }

    public function getAllLeaveRequest($leaverequestId)
    {
        try {
            return $this->leaverequest->whereUserId($leaverequestId)->get();
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($leaverequestId, array $data)
    {
        try {
            $data['last_updated_by']= Auth::user()->id;
            if(isset($data['is_approved']) && $data['is_approved'] == 'on') {
                $data['approved_by']= Auth::user()->id;
                $data['approved_date']= Carbon::now();
                $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? '1' : '0';
            } else {
                $data['is_approved'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? '1' : '0';
                $data['approved_by']= null;
                $data['approved_date']= null;
            }
            $leaverequest= $this->leaverequest->find($leaverequestId);
            $leaverequest = $leaverequest->update($data);
            //$this->logger->info(' created successfully', $data);

            return $leaverequest;
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
    public function delete($leaverequestId)
    {
        try {
            $leaverequest = $this->leaverequest->whereNull('status')->where('id', $leaverequestId)->first();
            if($leaverequest && ($leaverequest->user_id == auth()->user()->id || auth()->user()->user_type == "SUPER ADMIN")) {
                return $leaverequest = $leaverequest->delete();
            } else {

                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * write brief description
     * @param $name
     * @return mixed
     */
    public function getByName($name){
        return $this->leaverequest->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->leaverequest->whereIsDeleted('no')->whereSlug($slug)->first();
    }

    public function getById($id){
        return $this->leaverequest->whereUserId($id)->orderBy('start_date', 'DESC')->get();
    }

    public function groupByDate(){
        return DB::table('leave_requests')
                ->select(\DB::raw('YEAR(start_date) as year'))
                ->groupBy(\DB::raw('YEAR(start_date)'))
                ->orderBy(\DB::raw('YEAR(start_date)'))
                ->get();
    }

    public function getUserDetail($id){
        return $this->user->whereId($id)->first();
    }



    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/leaverequest';
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

    public function updateImage($leaverequestId, array $data)
    {
        try {
            $leaverequest = $this->leaverequest->find($leaverequestId);
            $leaverequest = $leaverequest->update($data);

            return $leaverequest;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    /*For Approved Request List DataTable*/
    public function getAllApprovedLeaveRequest()
    {
        $query = $this->leaverequest->whereNull('status')->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('user_id',function(LeaveRequest $leaverequest) {
                if($leaverequest->user->first_name) {
                    return $leaverequest->user->first_name.' '.$leaverequest->user->last_name;
                }
            })
            ->editColumn('leave_type',function(LeaveRequest $leaverequest) {
                if($leaverequest->leavetype->name) {
                    return $leaverequest->leavetype->name;
                }
            })
            ->editcolumn('actions',function(LeaveRequest $leaverequest) {


                return '<button type="button" class="btn btn-primary btn-approve btn-sm" onclick="approvedthis('.($leaverequest->id).')" value="1">Approve</button>
                        <button type="button" class="btn btn-danger btn-reject btn-sm"  onclick="rejectthis('.($leaverequest->id).')">Deny</button>
                        <button type="button" class="btn btn-success waves-effect waves-light btn-sm viewhistory" data-user_id="'.($leaverequest->user->id).'">View History</button>
                ';

            })->rawColumns(['actions'])->make(true);
    }

    /*All leave request for Line Manager DataTable*/
    public function getAllApprovedLeaveRequestForLineManagerData()
    {
        $model = \DB::table('leave_requests as l')
                    ->select('u.name', 'l.*', 'lt.name as leave_type_name')
                    ->join('line_managers as lm', 'l.user_id', 'lm.user_id')
                    ->join('users as u', 'l.user_id', 'u.id')
                    ->leftjoin('leave_types as lt', 'lt.id', 'l.leave_type')
                    ->where('line_manager_id', \Auth::user()->id);

        return DataTables::of($model)
            ->editColumn('status', function($model) {
                if($model->status == '0') {
                    return "<span class='badge badge-danger'> Rejected </span>";
                }
                elseif($model->status == '1') {
                    return "<span class='badge badge-primary'> Approved </span>";
                }
                else{
                    return "<span class='badge badge-warning'> Pending </span>";
                }
            })
            ->rawColumns(['status'])
            ->make(true);
    }


    public function getPendingLeaveRequestForLineManager()
    {
        $model = \DB::table('leave_requests as l')
                        ->select('u.name', 'l.*', 'lt.name as leave_type_name')
                        ->join('line_managers as lm', 'l.user_id', 'lm.user_id')
                        ->join('users as u', 'l.user_id', 'u.id')
                        ->join('leave_types as lt', 'lt.id', 'l.leave_type')
                        ->where('line_manager_id', \Auth::user()->id)
                        ->whereNull('l.status');

        return DataTables::of($model)
            ->editcolumn('actions',function($model) {
                return '<button type="button" class="btn btn-primary btn-approve btn-sm" onclick="approvedthis('.$model->id.')" value="1">Approve</button>
                <button type="button" class="btn btn-danger btn-reject btn-sm"  onclick="rejectthis('.$model->id.')">Deny</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-sm viewhistory" data-user_id="'.$model->user_id.'">View History</button>';

            })->rawColumns(['actions'])->make(true);
    }

    public function getRemainingDays()
    {
        // $query = "SELECT tf.user_name, sum(tf.sick_leave) as remaining_sick_days,sum(tf.annual_leave) as remaining_annual_days FROM
        // (SELECT ttt.user_name,
        // CASE WHEN (ttt.name='Sick Leave') THEN ttt.remain_days ELSE 0 END AS sick_leave,
        // CASE WHEN (ttt.name='Annual Leave') THEN ttt.remain_days ELSE 0 END AS annual_leave FROM
        // (select users.name as user_name, ttabsent.*,(ttabsent.total_days-ttabsent.sub_total) as remain_days from users INNER JOIN
        // (SELECT sum(sub_total) as sub_total,user_id,name,total_days FROM
        // (SELECT absent_requests.id,absent_requests.user_id,absent_requests.sub_total,leave_types.name,leave_types.total_days FROM `absent_requests`  inner JOIN leave_types
        //     on absent_requests.leave_type = leave_types.id and absent_requests.is_approved=1)as tabsent
        //     GROUP by user_id,name,total_days) as ttabsent ON users.id=ttabsent.user_id) as ttt
        //     group by ttt.user_name,ttt.name) as tf
        //     GROUP BY tf.user_name;";
        $year = date('Y');

        $query = "SELECT * FROM
        (SELECT name,user_id,annual_leave,sick_leave,tannual_leave,tsick_leave,(tannual_leave - annual_leave) as remain_annual_leave,(tsick_leave - sick_leave) as remain_sick_leave from
                (select * from
                (select name,user_id,sum(annual_leave) as annual_leave,sum(sick_leave) as sick_leave from (select name,user_id,leave_type, CASE WHEN (leave_type=1) THEN tleave ELSE 0 END as annual_leave, CASE WHEN (leave_type=2) THEN tleave ELSE 0 END as sick_leave from (select name,user_id,leave_type, sum(sub_total) as tleave From (select users.name,users.id as user_id,users.status,leave_requests.sub_total,leave_requests.leave_type from users left join leave_requests on users.id=leave_requests.user_id and leave_requests.status=1 and year(leave_requests.end_date) = $year) AS tt where status='1' GROUP BY name,user_id,leave_type) as ttt group by name,user_id,leave_type,tleave) AS tttt group by name,user_id) rfinal

                cross join

                (SELECT sum(tannual_leave) as tannual_leave, sum(tsick_leave) as tsick_leave FROM (select CASE WHEN (name='Annual Leave') THEN total_days ELSE 0 END as tannual_leave, CASE WHEN (name='Sick Leave') THEN total_days ELSE 0 END as tsick_leave FROM leave_types GROUP by name,total_days) as tabsentType) as tfabsent) as finalResult) tfinalResult
          LEFT JOIN
          (SELECT user_id AS id,sum(u_annual_leave) as u_annual_leave,sum(u_sick_leave) as u_sick_leave FROM
        (select user_id,CASE WHEN (leave_type=1) THEN total_days ELSE 0 END as u_annual_leave, CASE WHEN (leave_type=2) THEN total_days ELSE 0 END as u_sick_leave FROM user_leave_entitlements GROUP by user_id,leave_type,total_days) AS tUserLeave GROUP By user_id) AS fUserLeave
        ON tfinalResult.user_id = fUserLeave.id;
        ";
        return DB::select($query);

    }

    /*For Report List DataTable*/
    public function getReport()
    {
        $absent_query = $this->getRemainingDays();
        return DataTables::of($absent_query)
            ->addIndexColumn()
            ->editColumn('remain_annual_leave',function($absent_query) {
                if(isset($absent_query->u_annual_leave)) {
                    $u_remain_annual_leave = $absent_query->u_annual_leave - $absent_query->annual_leave;
                    return $u_remain_annual_leave;
                } else {
                    return $absent_query->remain_annual_leave;
                }
            })
            ->editColumn('remain_sick_leave',function($absent_query) {
                if(isset($absent_query->u_sick_leave)) {
                    $u_remain_sick_leave = $absent_query->u_sick_leave - $absent_query->sick_leave;
                    return $u_remain_sick_leave;
                } else {
                    return $absent_query->remain_sick_leave;
                }
            })
            ->make(true);
    }

    public function getRemainingDaysForParticularMonth($monthid, $year)
    {

        $month = $monthid;
        $year = $year;
        $query = "SELECT tt.*,u.name as request_name,userstatus.name as status_user FROM
        (SELECT l.id,l.user_id,l.start_date,l.end_date,l.sub_total,l.type,l.created_at,l.status_user,lt.name FROM leave_requests l INNER JOIN leave_types lt on l.leave_type = lt.id AND l.status = 1  AND month(l.start_date) = $month AND year(l.end_date) = $year) as tt
        INNER JOIN users u on tt.user_id = u.id
        INNER JOIN users userstatus on tt.status_user = userstatus.id;";
        return DB::select($query);

    }

    /*For Report List By Month DataTable*/
    public function getReportByMonth($monthid, $year)
    {
        $absent_query = $this->getRemainingDaysForParticularMonth($monthid,$year);
        return DataTables::of($absent_query)
            ->addIndexColumn()
            ->editColumn('request_name',function($absent_query) {
                return $absent_query->request_name;
            })
            ->editColumn('from',function($absent_query) {
                return $absent_query->start_date;
            })
            ->editColumn('to',function($absent_query) {
                return $absent_query->end_date;
            })
            ->editColumn('absent_type',function($absent_query) {
                return $absent_query->name;
            })
            ->editColumn('type',function($absent_query) {
                return $absent_query->type;
            })
            ->editColumn('sub_total',function($absent_query) {
                return $absent_query->sub_total .' Day';
            })
            ->editColumn('status_user',function($absent_query) {
                return $absent_query->status_user;
            })
            ->editcolumn('actions',function($absent_query) {
                return '<a  href="' . route('leaverequest.show',$absent_query->id) . '"><i class="fas fa-eye" data-id=""></i></a>';

            })->rawColumns(['actions'])->make(true);
    }

    public function isapproved($leaverequestId)
    {
        try {
            $data['last_updated_by']= Auth::user()->id;
            $data['status_user']= Auth::user()->id;
            $data['approved_date']= Carbon::now();
            $data['status'] = '1';
            $leaverequest= $this->leaverequest->find($leaverequestId);
            $leaverequest = $leaverequest->update($data);
            //$this->logger->info(' created successfully', $data);

            return $leaverequest;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function isrejected($leaverequestId)
    {
        try {
            $data['last_updated_by']= Auth::user()->id;
            $data['status_user']= Auth::user()->id;
            $data['approved_date']= Carbon::now();
            $data['status'] = '0';
            $leaverequest= $this->leaverequest->find($leaverequestId);
            $leaverequest = $leaverequest->update($data);
            //$this->logger->info(' created successfully', $data);

            return $leaverequest;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function checkLeaveRequest($request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $startyear = date('Y', strtotime($start_date));
        $endyear = date('Y', strtotime($end_date));
        if($startyear != $endyear) {
            Toastr()->error('You cannot select the leave request in two different year.Please create separate request for different year.','Sorry');
            return false;
        }
        $leave = $this->leaverequest->where('status',1)->where(function($query) use ($start_date, $end_date){
                                $query->whereBetween('start_date', [$start_date, $end_date]);
                                $query->orWhereBetween('end_date', [$start_date, $end_date]);
                                    })->get();
        if($request->user_id) {
            $leave = $leave->where('user_id', $request->user_id);
        }
        else {
            $leave = $leave->where('user_id', auth()->user()->id);
        }

        $leave = $leave->first();
        if(isset($leave)) {
            Toastr()->error('In the Requested date, Your absent request has been already approved','Sorry');
            return false;
        }

        return true;
    }
}

