<?php

namespace App\Http\Controllers\HRIS;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\CompanyFeature;
use App\Models\Feature;
use App\Models\HRIS\Role;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{

    protected $generalHelper;

    public function __construct()
    {
        $this->generalHelper = new GeneralHelper();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('backend.hris.role.index');
    }

    public function create()
    {
        $groupPermissions = $this->generalHelper->getPermissionForRole();

        return view('backend.hris.role.create', compact('groupPermissions'));
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
        try {
            $permission = [];
            if ($request->permissions)
                foreach ($request->permissions as $permiss)
                    $permission[] = $permiss;

            $request->request->add(['company_id' => auth()->user()->company_id]);
            $request->request->add(['permission' => json_encode($permission)]);
            Role::create($request->all());
            return redirect()->route('hris.role.index')->with('message', 'Role Created Successfully');
        } catch (Exception $ex) {
            return redirect()->route('hris.role.index')->with('message', $ex->getMessage());
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
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $rolePermissions = json_decode($role->permission, true);
        $groupPermissions = $this->generalHelper->getPermissionForRole();

        return view('backend.hris.role.edit', compact('groupPermissions', 'rolePermissions', 'role'));
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
        // dd($request->permissions);
        try {
            $permission = [];

            if ($request->permissions)
                foreach ($request->permissions as $permiss)
                    $permission[] = $permiss;

            // $companyFeatures = CompanyFeature::select('feature_id')->where('company_id', auth()->user()->company_id)->get();
            // foreach ($companyFeatures as $companyFeature)
            //     $cFeature[] = $companyFeature->feature_id;

            // $defaultPermiss = Permission::select('name')->whereIn('feature_id', $cFeature)->where('is_default', 'YES')->get();
            // foreach ($defaultPermiss as $defaultP)
            //     $permission[] = $defaultP;

            // $request->request->add(['company_id' => auth()->user()->company_id]);
            // $request->request->add(['permission' => json_encode($permission)]);
            $permission = json_encode($permission);
            $role = Role::findOrFail($request->role_id);

            $role->permission = $permission;
            $role->save();
            return redirect()->route('hris.role.index')->with('success', 'Role Updated Successfully');
        } catch (Exception $ex) {
            return redirect()->route('hris.role.index')->with('error', $ex->getMessage());
            // return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
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
        return DataTables::of(Role::getAllRoles())
            ->addIndexColumn()

            ->editColumn('action', function ($model) {
                return auth()->user()->company_id ? '<a href="' . route('hris.role.edit', ['id' => $model->role_id]) . '"><i class="fas fa-edit custom_edit"></i> </a>' : "";
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }
}
