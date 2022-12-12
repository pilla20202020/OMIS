<?php

namespace App\Http\Controllers\HRIS;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Designation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $generalHelper;
    public function __construct(GeneralHelper $generalHelper)
    {
        $this->generalHelper = $generalHelper;
    }
    public function index()
    {
        $departments = $this->generalHelper->getDepartments(auth()->user()->company_id, auth()->user()->branch_id);
        return view('backend.hris.designation.index', compact('departments'));
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
                'designation_name.unique' => 'Designation name, :input already  exists!',
            ];
            Validator::make(
                $request->all(),
                [
                    'designation_name' => [
                        'required',
                        Rule::unique('designations')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                                ->where('branch_id', auth()->user()->branch_id)
                                ->where('dept_id', $request->dept_id)
                                ->where('designation_name', $request->designation_name);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $request->request->add(['company_id' => auth()->user()->company_id]);
                $request->request->add(['branch_id' => auth()->user()->branch_id]);
                Designation::create($request->all());
                return response()->json(['status' => true, 'message' => 'Designation Created Successfully'], 200);
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
                $data = Designation::findOrFail($request->designation_id);
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
                'dept_id.required' => 'Select department is required!',
                'designation_name.unique' => 'Designation name, :input already  exists!',
            ];
            Validator::make(
                $request->all(),
                [
                    'dept_id'=> ['required'],
                    'designation_name' => [
                        'required',
                        Rule::unique('designations')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                                ->where('branch_id', auth()->user()->branch_id)
                                ->where('dept_id', $request->dept_id)
                                ->where('designation_id','<>', $request->designation_id)
                                ->where('designation_name', $request->designation_name);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $data = Designation::findOrFail($request->designation_id);
                $data->update($request->all());
                return response()->json(['status' => true, 'message' => 'Designation Updated Successfully'], 200);
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
        return DataTables::of(Designation::getAllDesignations())
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return auth()->user()->company_id ? '<i class="fas fa-edit custom_edit" data-id="' . $model->designation_id . '"></i>' : "";
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }

    public function getDesignationByDeptId(Request $request)
    {
       return $this->generalHelper->getDesignationByDeptId($request->dept_id);
    }
}
