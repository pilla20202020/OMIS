<?php

namespace App\Http\Controllers\HRIS;

use App\Http\Controllers\Controller;
use App\Models\HRIS\Shift;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('backend.hris.shift.index');
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
                'shift_type.unique' => 'Shift type, :input already  exists!',
            ];
            Validator::make(
                $request->all(),
                [
                    'shift_type' => [
                        'required',
                        Rule::unique('shifts')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                                ->where('branch_id', auth()->user()->branch_id)
                                ->where('shift_type', $request->shift_type);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $request->request->add(['company_id' => auth()->user()->company_id]);
                $request->request->add(['branch_id' => auth()->user()->branch_id]);
                $start_shift = new DateTime($request->start_shift);
                $start_shift = $start_shift->format('H:i:s');

                $end_shift = new DateTime($request->end_shift);
                $end_shift = $end_shift->format('H:i:s');
                $request->merge(['start_shift' => $start_shift]);
                $request->merge(['end_shift' => $end_shift]);

                Shift::create($request->all());
                return response()->json(['status' => true, 'message' => 'Shift Created Successfully'], 200);
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
                $data = Shift::findOrFail($request->shift_id);
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
                'shift_type.unique' => 'Shift type, :input already  exists!',
            ];
            Validator::make(
                $request->all(),
                [
                    'shift_type' => [
                        'required',
                        Rule::unique('shifts')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                                ->where('branch_id', auth()->user()->branch_id)
                                ->where('shift_id','<>', $request->shift_id)
                                ->where('shift_type', $request->shift_type);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $data = Shift::findOrFail($request->shift_id);

                $start_shift = new DateTime($request->start_shift);
                $start_shift = $start_shift->format('H:i:s');

                $end_shift = new DateTime($request->end_shift);
                $end_shift = $end_shift->format('H:i:s');
                $request->merge(['start_shift' => $start_shift]);
                $request->merge(['end_shift' => $end_shift]);
                $data->update($request->all());
                return response()->json(['status' => true, 'message' => 'Shift Updated Successfully'], 200);
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
        return DataTables::of(Shift::getAllShifts())
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return auth()->user()->company_id ? '<i class="fas fa-edit custom_edit" data-id="' . $model->shift_id . '"></i>' : "";
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }
}
