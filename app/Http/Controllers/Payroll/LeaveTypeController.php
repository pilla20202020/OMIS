<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payroll\LeaveType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('backend.payroll.leave-type.index');
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
                'leave_type.unique' => 'Leave type, :input already  exists!',
            ];
            Validator::make(
                $request->all(),
                [
                    'leave_type' => [
                        'required',
                        Rule::unique('leave_types')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                                // ->where('branch_id', auth()->user()->branch_id)
                                ->where('leave_type', $request->leave_type);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $request->request->add(['company_id' => auth()->user()->company_id]);
                LeaveType::create($request->all());
                return response()->json(['status' => true, 'message' => 'Leave Type Created Successfully'], 200);
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
                $data = LeaveType::findOrFail($request->id);
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
                'leave_type.unique' => 'Leave type, :input already  exists!',
            ];
            Validator::make(
                $request->all(),
                [
                    'leave_type' => [
                        'required',
                        Rule::unique('leave_types')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                                ->where('id','<>', $request->id)
                                ->where('leave_type', $request->leave_type);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $data = LeaveType::findOrFail($request->id);
                $data->update($request->all());
                return response()->json(['status' => true, 'message' => 'Leave Type Updated Successfully'], 200);
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
        return DataTables::of(LeaveType::getAllLeaveTypes())
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return auth()->user()->company_id ? '<i class="fas fa-edit custom_edit" data-id="' . $model->id . '"></i>' : "";
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }
}
