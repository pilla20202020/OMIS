<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:webemployees');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('backend.config.user.index');
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
    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = User::findOrFail($request->user_id);
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
                $data = User::findOrFail($request->id);
                $data->update($request->all());
                return response()->json(['status' => true, 'message' => 'Feature Updated Successfully'], 200);
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
    public function destroy($id)
    {
        //
    }

    public function list(Request $request)
    {
        // return response()->json(['data'=>'abc']);
        // dd('testing');
        
        $query = "SELECT u.id, CONCAT(u.first_name, ' ',u.last_name) AS user_name, u.user_type,u.mobile,u.email,u.`status`,
        u.created_at,u.updated_at,CONCAT(cu.first_name,' ',cu.last_name) AS created_by,CONCAT(uu.first_name,' ',uu.last_name)
        AS updated_by,c.company_name
        FROM users u
        LEFT JOIN users cu ON u.created_by=cu.id
        LEFT JOIN users uu ON u.updated_by=uu.id
        LEFT JOIN companies c ON u.company_id=c.company_id ";

        // if (auth()->user()->company_id)
        //     $query .= " AND u.company_id=" . auth()->user()->company_id;

        $query .= " order by u.id desc";

        $model = DB::select($query);
        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('action', function ($model) {
                // return auth()->user()->company_id ? '<i class="fas fa-edit custom_edit" data-id="' . $model->id . '"></i>' : "";
                return "";
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }
}
