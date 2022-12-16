<?php

namespace App\Http\Controllers\HRIS;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $generalhelper;
    public function __construct(GeneralHelper $generalhelper)
    {
        $this->generalhelper = $generalhelper;
    }
    public function index()
    {
        $companies = $this->generalhelper->getCompanies();
        $branches = $this->generalhelper->getBranches(auth()->user()->company_id);
        return view('backend.hris.department.index', compact('companies', 'branches'));
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
        if ($request->ajax()) {
            $messages = [
                'department_name.unique' => 'Department Name, :input already  exists!',
            ];
            Validator::make(
                $request->all(),
                [
                    'department_name' => [
                        'required',
                        Rule::unique('departments')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                                ->where('branch_id', auth()->user()->branch_id)
                                ->where('department_name', $request->branch_name);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $request->request->add(['company_id' => auth()->user()->company_id]);
                $request->request->add(['branch_id' => auth()->user()->branch_id]);
                Department::create($request->all());
                return response()->json(['status' => true, 'message' => 'Department Created Successfully'], 200);
            } catch (Exception $ex) {
                return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
            }
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
                $data = Department::findOrFail($request->dept_id);
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
            $messages = [
                'department_name.unique' => 'Department Name, :input already  exists!',
            ];
            Validator::make(
                $request->all(),
                [
                    'department_name' => [
                        'required',
                        Rule::unique('departments')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                                ->where('branch_id', auth()->user()->branch_id)
                                ->where('dept_id', '<>', $request->dept_id)
                                ->where('department_name', $request->department_name);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $data = Department::findOrFail($request->dept_id);
                $data->update($request->all());
                return response()->json(['status' => true, 'message' => 'Department Updated Successfully'], 200);
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
        return DataTables::of(Department::getAllDepartments())
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return auth()->user()->branch_id && permission('hris.department.edit')? '<i class="fas fa-edit custom_edit" data-id="' . $model->dept_id . '"></i>' : "";
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }
}
