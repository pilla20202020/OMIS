<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payroll\EmployeeAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $dept_id = $request->query('dept');
        $shift_id = $request->query('shift');
        // dd($shift_id,$dept_id);
        $company_id = auth()->user()->company_id;
        $departments = getDepartments($company_id);
        $shifts = getShifts($company_id);

        $dept_id = $dept_id != 'All' ? $dept_id : null;
        $shift_id = $shift_id != 'All' ? $shift_id : null;
        $employees = getEmployees($company_id, $dept_id, $shift_id);

        $leaveTypes = getLeaveTypes($company_id);

        return view('backend.payroll.attendance.create', compact('departments', 'employees', 'leaveTypes', 'shifts'));
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
        // dd($request->all());
        //Here We have to use transaction
        DB::transaction(function () use ($request) {
            // dd($request->all());
            foreach ($request->emp_id as $key => $empId) {
                $attendenceExists = EmployeeAttendance::where('emp_id', $empId)->where('date', $request->date)->first();
                $company_id = auth()->user()->company_id;
                $branch_id = auth()->user()->branch_id;
                if ($attendenceExists) {
                    $attendenceExists->update([
                        'status' => $request->status[$empId],
                        'leave_type_id' => $request->leave_type_id[$empId],
                        'late_minute' => $request->late_minute[$empId],
                        'present_type' => $request->present_type[$empId],
                        'reason' => $request->reason[$empId],
                    ]);
                } else {
                    EmployeeAttendance::create([
                        'emp_id' => $request->emp_id[$empId],
                        'company_id' => $company_id,
                        'branch_id' => $branch_id,
                        'year' => date('Y'),
                        'date' => $request->date,
                        'status' => $request->status[$empId],
                        'leave_type_id' => $request->leave_type_id[$empId],
                        'late_minute' => $request->late_minute[$empId],
                        'present_type' => $request->present_type[$empId],
                        'reason' => $request->reason[$empId],
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Attendance Successfully Created or Updated.');
    }

    public function report(Request $request)
    {
        $dept_id = $request->query('dept');
        $shift_id = $request->query('shift');
        // dd($shift_id,$dept_id);
        $company_id = auth()->user()->company_id;
        $departments = getDepartments($company_id);
        $shifts = getShifts($company_id);

        $dept_id = $dept_id != 'All' ? $dept_id : null;
        $shift_id = $shift_id != 'All' ? $shift_id : null;
        $employees = getEmployees($company_id, $dept_id, $shift_id);

        $leaveTypes = getLeaveTypes($company_id);
        $date = Carbon::now();
        $EmpAttendance = EmployeeAttendance::where('company_id', $company_id)->where('emp_id', 1)
            ->whereMonth('date', $date->month)
            ->get()->toArray();
        // dd($EmpAttendance);
        return view('backend.payroll.attendance.report', compact('departments', 'employees', 'leaveTypes', 'shifts'));
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
                $data = Employee::findOrFail($request->emp_id);
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
            try {
                $data = Employee::findOrFail($request->emp_id);

                $start_Employee = new DateTime($request->start_Employee);
                $start_Employee = $start_Employee->format('H:i:s');

                $end_Employee = new DateTime($request->end_Employee);
                $end_Employee = $end_Employee->format('H:i:s');
                $request->merge(['start_Employee' => $start_Employee]);
                $request->merge(['end_Employee' => $end_Employee]);
                $data->update($request->all());
                return response()->json(['status' => true, 'message' => 'Employee Updated Successfully'], 200);
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
    public function delete($id)
    {
        //
    }

    public function list(Request $request)
    {
        return DataTables::of(Employee::getAllEmployees())
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return  auth()->user()->company_id ? '<i class="fas fa-edit custom_edit" data-id="' . $model->emp_id . '"></i>' : "";
                // return '<i class="fas fa-edit custom_edit" data-id="' . $model->emp_id . '"></i>';
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }
}
