<?php

namespace App\Http\Controllers\Leave\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Leave\UserLeaveEntitlements\UserLeaveEntitlements;
use App\Service\LeaveRequest\LeaveRequestService;
use App\Service\LeaveTypes\LeaveTypesService;
use App\Service\Holiday\HolidayService;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $absentrequest,$leavetypes,$user,$holiday,$userleaveentitlements;

    public function __construct(LeaveRequestService $absentrequest,LeaveTypesService $leavetypes,User $user,HolidayService $holiday,UserLeaveEntitlements $userleaveentitlements)
    {
        $this->absentrequest = $absentrequest;
        $this->leavetypes = $leavetypes;
        $this->user = $user;
        $this->holiday = $holiday;
        $this->userleaveentitlements = $userleaveentitlements;
    }
    public function index()
    {
        //
        $leavetypes = $this->leavetypes->paginate();
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
        $leaverequests = $this->absentrequest->getSubTotal();
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
        $total_days = 0;
        foreach($remaining_days as $data)
        {
            $total_days += $data;
        }
        $userabsentrequests = $this->absentrequest->getRecentLeaveRequestOfUser();
        $upcomingleaverequests = $this->absentrequest->getUpComingLeaveRequestOfUser();
        $upcomingholidays = $this->holiday->getUpcomingHoliday();
        $allholidays = $this->holiday->getAllHoliday();
        $absentrequestleaveforcalender = $this->absentrequest->getAllLeaveRequestsForCalendar();

        return view('dashboard.index',compact('remaining_days','total_days','userabsentrequests','upcomingleaverequests','upcomingholidays','absentrequestleaveforcalender','allholidays'));

    }

    public function calendar()
    {
        $allholidays = $this->holiday->getAllHoliday();
        $absentrequestleaveforcalender = $this->absentrequest->getAllLeaveRequestsForCalendar();
        return view('backend.leave.calendar.index',compact('absentrequestleaveforcalender','allholidays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getEventLeaveRequest(Request $request) {
        // dd($this->absentrequest->getAllLeaveRequestOfUser()->where('start_date', '>=', $request->start)->where('end_date',   '<=', $request->end));
        if($request->ajax())
    	{
    		$data = $this->absentrequest->getAllLeaveRequestOfUserForCalendar()->where('start_date', '>=', $request->start)
                       ->where('end_date',   '<=', $request->end)->first();
            return response()->json($data);
    	}
    	return view('');
    }

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
}
