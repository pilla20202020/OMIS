<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $features = Feature::getAllActiveFeatures();
        return view('backend.config.permission.index', compact('features'));
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
        // dd($request->permission_id);
        try {
            $route = Permission::updateOrCreate(['permission_id'=> $request->permission_id], $request->all());
            if ($request->permission_id)
                $message = "Permission Updated Successfully";
            else
                $message = "Permission Created Successfully";

            return response()->json(['status' => true, 'message' => $message]);
        } catch (Exception $ex) {
            return response()->json(['status' => true, 'message' => $ex->getMessage()]);
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
                $route = Permission::where(['permission_id' => $request->permission_id])->firstOrFail();
                return response()->json(['status' => true, 'route' => $route], 200);
            } catch (Exception $ex) {
                return response()->json(['status' => false, 'route' => $ex->getMessage()], 200);
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

    public function list(Request $request)
    {
        return DataTables::of(Permission::getAllpermissionDataList())
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return '<i class="fas fa-edit custom_edit" data-permission_id="' . $model->permission_id . '"></i>';
            })
            ->toJson();
    }
}
