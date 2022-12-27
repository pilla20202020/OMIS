<?php

namespace App\Http\Controllers\Leave\LeaveRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveRequest\Leave_RequestRequest;
use App\Jobs\ApprovedLeaveRequest;
use App\Jobs\ProcessLeaveRequest;
use App\Jobs\RejectedLeaveRequest;
use App\Mail\LeaveRequestApproved;
use App\Mail\LeaveRequestRejected;
use App\Mail\SendLeaveRequest;
use App\Mail\SendLeaveRequestToUser;
use App\Models\LeaveRequest\LeaveRequest;
use App\Models\User;
use App\Models\Leave\UserLeaveEntitlements\UserLeaveEntitlements;
use App\Service\LeaveRequest\LeaveRequestService;
use App\Service\LeaveTypes\LeaveTypesService;
use App\Service\User\UserService;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $leave_service, $leave_types, $userleaveentitlements;

    public function __construct(LeaveRequestService $leave_service, LeaveTypesService $leavetypes,User $user, UserLeaveEntitlements $userleaveentitlements)
    {
        $this->leave_service = $leave_service;
        $this->leavetypes = $leavetypes;
        $this->user = $user;
        $this->userleaveentitlements = $userleaveentitlements;
    }

    public function index()
    {
        $leaverequests = $this->leave_service->paginate();
        return view('backend.leave.leave_request.index',compact('leaverequests'));
    }

    public function getAllData()
    {
        return $this->leave_service->getAllData();
    }

    public function userleaverequest()
    {
        //
        $leaverequests = $this->leave_service->paginate();
        return view ('backend.leave.leave_request.userleaverequest',compact('leaverequests'));
    }

    public function getAllUserData()
    {
        return $this->leave_service->getAllUserData();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leavetypes = $this->leavetypes->paginate();
        $users = $this->user->all();

        $userleaveentitlements = $this->userleaveentitlements->where('user_id',auth()->user()->id)->get();

        if(!empty($userleaveentitlements->first())) {
            foreach ($userleaveentitlements as $key => $data) {
                if(isset($data)) {
                    $leavedays[$data->leavetype->name] = $data->total_days;
                }
            }
        } else {
            foreach ($leavetypes as $key => $data) {
                if(isset($data)) {
                    $leavedays[$data->name] = $data->total_days;
                }
            }
        }
        $leaverequests = $this->leave_service->getSubTotal();
        $userleavedays = null;
        foreach($leaverequests as $leavedata) {
            $userleavedays[$leavedata->name] = $leavedata->sub_total;
        }

        foreach ($leavedays as $key => $value) {
            if($userleavedays != null) {
                if(array_key_exists($key, $userleavedays) && array_key_exists($key, $leavedays))
                    $ret[$key] = $leavedays[$key] - $userleavedays[$key];
            }

        }
        if($userleavedays != null)
        {
            $temp = array_diff_key($leavedays,$ret);
            $remaining_days=array_merge($temp,$ret);
            ksort($remaining_days);
        } else{
            $remaining_days = $leavedays;
        }
        return view('backend.leave.leave_request.create',compact('leavetypes','remaining_days','users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Leave_RequestRequest $request)
    {
        $leave_valid = $this->leave_service->checkLeaveRequest($request);

        if($leave_valid == true){
            $leave_request = $this->leave_service->create($request->all());

//            $user = $leave_request->user;
//
//            return view('mail.sendleaverequest',['user' => $user, 'leaverequest' => $leave_request]);

            ProcessLeaveRequest::dispatch($leave_request)
                    ->delay(now()->addSeconds(7));

            Toastr()->success('Leave Request has been created','Success');
            return redirect()->route('leaverequest.index');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leaverequest = $this->leave_service->find($id);
        return view('backend.leave.leave_request.show',compact('leaverequest'));

    }

    public function print($id)
    {
        //
        $leaverequest = $this->leave_service->find($id);
        return view('backend.leave.leave_request.print',compact('leaverequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if($this->leave_service->update($id,$request->all()))
        {
            return redirect()->route('leaverequest.index');
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
        $deletethis = $this->leave_service->delete($id);
        if($deletethis == true){
            Toastr()->success('The leave request has been deleted','Success');
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    // To count Total number of days
    public function getTotalDays(Request $request) {
        $startdate = new DateTime($request['start_date']);
        $enddate = new DateTime($request['end_date']);
        $enddate->modify('+1 day');
        $interval = $enddate->diff($startdate);

        $days = $interval->days;
        $period = new DatePeriod($startdate, new DateInterval('P1D'), $enddate);

        foreach($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }

        }
        if($request['type'] == "half") {
            $days = $days/2;
        } else {
            $days = $days;
        }
        return response()->json([
            'data' => $days,
            'status' => true,
            'message' => "Total Number Of Days."
        ]);

    }

    // For Report List
    public function report() {
        $users = $this->user->all();
        return view('backend.leave.leave_request.report',compact('users'));
    }

    public function getReport()
    {
        return $this->leave_service->getReport();
    }

    // For Report List

    // For Report By Month List
    public function reportByMonth() {
        $years = $this->leave_service->groupByDate();
        $date = Carbon::now();
        $month = $date->month;
        $current_year = date('Y');
        return view ('backend.leave.leave_request.reportbymonth',compact('years','month','current_year'));
    }

    public function particularMonth(Request $request)
    {
        $month = $request->month;
        $current_year = $request->year;
        $years = $this->leave_service->groupByDate();

        return view ('backend.leave.leave_request.particularmonth',compact('month','current_year','years'));

    }

    public function getReportByMonth($monthid, $year)
    {

        return $this->leave_service->getReportByMonth($monthid,$year);
    }

    // For Report By Month List


    // Request For Approval
    public function approveLeaveRequest() {
        $leaverequests = $this->leave_service->paginate();
        return view('backend.leave.leave_request.approved_list',compact('leaverequests'));
    }

    public function getAllLeaveRequest()
    {
        return $this->leave_service->getAllApprovedLeaveRequest();
    }

    public function toApprove(Request $request) {
        $leaverequest = $this->leave_service->find($request->approved_id);
        $userdetail = $this->leave_service->getUserDetail($leaverequest->user_id);


        if($data = $this->leave_service->isapproved($request->approved_id))
        {

            ApprovedLeaveRequest::dispatch($data, $userdetail, $leaverequest)
                    ->delay(now()->addSeconds(7));
            Toastr()->success('Leave Request has been Approved','Success');
            return response()->json([
                'data' => $data,
                'status' => true,
                'message' => "Requst Leave Updated Successfully."
            ]);
        }
    }

    public function toReject(Request $request) {
        $leaverequest = $this->leave_service->find($request->rejected_id);
        $userdetail = $this->leave_service->getUserDetail($leaverequest->user_id);

        if($data = $this->leave_service->isrejected($request->rejected_id))
        {
            RejectedLeaveRequest::dispatch($data, $userdetail, $leaverequest)
                    ->delay(now()->addSeconds(7));
            Toastr()->success('Leave Request has been Rejected','Rejected');
            return response()->json([
                'data' => $data,
                'status' => true,
                'message' => "Requst Leave Updated Successfully."
            ]);
        }
    }
    // Request For Approval


    // Get User Detail for Leave History
    public function getUserDetail(Request $request) {
        if($data = $this->leave_service->getById($request->user_id))
        {
            return response()->json([
                'data' => $data,
                'status' => true,
                'message' => "Requst Leave Updated Successfully."
            ]);
        }
    }

    public function getLeaveRequestForLineManager()
    {
        return view ('backend.leave.leave_request.linemanager.index');
    }

    public function getLeaveRequestForLineManagerData() {
        return $this->leave_service->getAllApprovedLeaveRequestForLineManagerData();
    }

    public function getPendingLeaveRequestForLineManager()
    {
        return view ('backend.leave.leave_request.linemanager.pending');
    }

    public function getPendingLeaveRequestForLineManagerData() {
        return $this->leave_service->getPendingLeaveRequestForLineManager();
    }
}
