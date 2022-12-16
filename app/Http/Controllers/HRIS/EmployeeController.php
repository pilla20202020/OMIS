<?php

namespace App\Http\Controllers\HRIS;

use App\Http\Controllers\Controller;
use App\Http\Requests\HRIS\EmployeeRequest;
use App\Models\HRIS\Employee;
use App\Models\HRIS\Role;
use App\Models\HRIS\RoleUser;
use App\Models\User;
use App\Models\UserPermission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $company_id = auth()->user()->company_id;
        $departments = getDepartments($company_id);
        $designations = getDesignations($company_id);
        $shifts = getShifts($company_id);
        $roles = getRoles($company_id);

        return view('backend.hris.employee.index', compact('departments', 'designations', 'shifts', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $employee = null;
        $userRole = null;
        $company_id = auth()->user()->company_id;
        if ($request->has('emp_id')) {
            $empId = $request->query('emp_id');
            $employee = Employee::findOrFail($empId);
            if ($employee->is_login == 'YES') {
                $userRole = getUserRoleByUserIdAndCompanyId($employee->user_id, $company_id);
            }
        }
        $departments = getDepartments($company_id);
        $designations = getDesignations($company_id);
        $shifts = getShifts($company_id);
        $roles = getRoles($company_id);

        return view('backend.hris.employee.create', compact('departments', 'designations', 'shifts', 'roles', 'employee', 'userRole'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        // dd($request->all());
        try {
            $inputData = $request->all();
            $inputData['user_type'] = 'EMPLOYEE';
            $inputData['company_id'] = auth()->user()->company_id;
            $inputData['branch_id'] = auth()->user()->branch_id;
            $result = DB::transaction(function () use ($inputData) {
                if ($inputData['is_login'] == 'YES') {

                    $inputData['password'] = Hash::make($inputData['password']);

                    $user = User::create($inputData);
                    $inputData['user_id'] =  $user->id;

                    if ($inputData['role_id'])
                        RoleUser::create($inputData);
                    // $role = Role::where('role_id', $inputData['role_id'])->where('company_id', $inputData['company_id'])->firstOrFail();
                    // UserPermission::create(['user_id' => $inputData['user_id'], 'permissions' => $role->permission]);
                }
                $employee = Employee::create($inputData);
            });
            return redirect()->route('hris.employee.index')->with('success', 'Employee Created Successfully');
            // return redirect()->route('hris.employee.index');
        } catch (Exception $ex) {
            return redirect()->route('hris.employee.index')->with('error', $ex->getMessage());
            // return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
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
                return  auth()->user()->branch_id && permission('hris.employee.edit') ? '<a href="' . route('hris.employee.create') . "?emp_id=" . $model->emp_id . '" <i class="fas fa-edit custom_edit" data-id="' . $model->emp_id . '"></i>' : "";
                // return '<i class="fas fa-edit custom_edit" data-id="' . $model->emp_id . '"></i>';
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }
}
