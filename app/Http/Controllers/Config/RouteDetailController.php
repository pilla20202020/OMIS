<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\RouteDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RouteDetailController extends Controller
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
        $features = Feature::getAllActiveFeatures();
        return view('backend.config.route.index', compact('features'));
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
    public function routeStore(Request $request)
    {
        // dd($request->all());
        try {
            $route = RouteDetail::updateOrCreate(['route_id'=> $request->route_id], $request->all());
            return redirect()->back()->with('success', 'Created Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('success', 'Created Successfully');
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
    public function getRouteEdit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $route = RouteDetail::where(['route_id' => $request->route_id])->firstOrFail();
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

    public function routeList(Request $request)
    {
        return DataTables::of(RouteDetail::getAllRoutesDataList())
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return '<i class="fas fa-edit custom_edit" data-route_id="' . $model->route_id . '"></i>';
            })
            ->toJson();
    }
}
