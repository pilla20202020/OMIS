<?php

namespace App\Http\Controllers\HRIS;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Branch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
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
        return view('backend.hris.branch.index', compact('companies'));
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
                'branch_name.unique' => 'Branch name, :input already  exists!',
            ];

            Validator::make(
                $request->all(),
                [
                    'branch_name' => [
                        'required',
                        Rule::unique('branches')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                            ->where('branch_name', $request->branch_name);
                        }),
                    ],
                ],
                $messages
            )->validate();
            try {
                $request->request->add(['company_id' => auth()->user()->company_id]);
                Branch::create($request->all());
                return response()->json(['status' => true, 'message' => 'Branch Created Successfully'], 200);
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
                $data = Branch::findOrFail($request->branch_id);
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
                'branch_name.unique' => 'Branch name, :input already  exists!',
            ];

            Validator::make(
                $request->all(),
                [
                    'branch_name' => [
                        'required',
                        Rule::unique('branches')->where(function ($query) use ($request) {
                            return $query->where('company_id', auth()->user()->company_id)
                            ->where('branch_id','<>', $request->branch_id)
                            ->where('branch_name', $request->branch_name);
                        }),
                    ],
                ],
                $messages
            )->validate();

            try {
                $data = Branch::findOrFail($request->branch_id);
                $data->update($request->all());
                return response()->json(['status' => true, 'message' => 'Branch Updated Successfully'], 200);
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
        // dd($request->all());
        return DataTables::of(Branch::getAllBranches($request->company_id))
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return auth()->user()->company_id  && permission('hris.branch.edit') ? '<i class="fas fa-edit custom_edit" data-id="' . $model->branch_id . '"></i> <a href="' . route('hris.branch.login-as-branch', [$model->branch_id]) . '" class="btn btn-block btn-success btn-sm">Login As Branch</a>' : "";
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }

    public function loginAsBranch($branch_id)
    {
        $user = auth()->user();
        $user->branch_id = $branch_id;
        if ($user->save())
            return redirect()->back()->with('success', 'Login as Branch Successfully');
    }

    public function rebackAsNormal()
    {
        $user = auth()->user();
        $user->branch_id = null;
        if ($user->save())
            return redirect()->back()->with('success', 'Back As Normal Successfully');
    }
}
