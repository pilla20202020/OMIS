<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\CompanyRequest;
use App\Models\Company;
use App\Models\CompanyFeature;
use App\Models\CompanyPermission;
use App\Models\Feature;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
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
        $features = Feature::where('feature_id', '!=', 1)->get()->chunk(4);
        // dd($feature);

        return view('backend.config.company.index', compact('features'));
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
    public function store(CompanyRequest $request)
    {
        // dd($permissions);
        if ($request->ajax()) {
            try {
                $result = DB::transaction(function () use ($request) {
                    $company = Company::create($request->all());
                    $request->merge([
                        'company_id' => $company->company_id,
                    ]);
                    $request->merge([
                        'password' => Hash::make($request->password),
                    ]);

                    $request->request->add(['user_type', 'COMPANY']);
                    $user = User::create($request->all());
                    foreach ($request->featureId as $id) {
                        CompanyFeature::create(['company_id' => $company->company_id, 'feature_id' => $id]);
                    }

                    $permissions = Permission::select('name')->whereIn('feature_id', $request->featureId)->get();
                    foreach ($permissions as $permission)
                        $allCompanyPermission[] = $permission->name;
                    CompanyPermission::create(['company_id' => $company->company_id, 'permission' => json_encode($allCompanyPermission)]);
                    UserPermission::create(['user_id' => $user->id, 'permissions' => json_encode($allCompanyPermission)]);
                });
                return response()->json(['status' => true, 'message' => 'Company Created Successfully'], 200);
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
                $company = Company::findOrFail($request->company_id);
                $companyFeatures = CompanyFeature::select('feature_id')->where('company_id', $request->company_id)->get();
                foreach ($companyFeatures as $companyFeature)
                    $cFeature[] = $companyFeature->feature_id;

                return response()->json(['status' => true, 'data' => ['company' => $company, 'companyFeature' => $cFeature]], 200);
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
        // dd($request->all());
        if ($request->ajax()) {
            try {
                $result = DB::transaction(function () use ($request) {
                    $company = Company::findOrFail($request->company_id);
                    $company->update($request->all());
                    CompanyFeature::where('company_id', $request->company_id)->delete();
                    foreach ($request->featureId as $id) {
                        CompanyFeature::create(['company_id' => $request->company_id, 'feature_id' => $id]);
                    }

                    $permissions = Permission::select('name')->whereIn('feature_id', $request->featureId)->get();
                    foreach ($permissions as $permission)
                        $allCompanyPermission[] = $permission->name;
                    $companyPermission = CompanyPermission::where('company_id', $company->company_id)->firstOrFail();
                    $companyPermission->update(['permission' => json_encode($allCompanyPermission)]);
                    $user = User::where('company_id', $request->company_id)->where('user_type', 'COMPANY')->firstOrFail();
                    $userPermission = UserPermission::where('user_id', $user->id)->firstOrFail();
                    $userPermission->update(['permissions' => json_encode($allCompanyPermission)]);
                });
                return response()->json(['status' => true, 'message' => 'Company Updated Successfully'], 200);
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
        $query = "SELECT c.company_id,c.company_name,c.company_email,c.company_phone,c.company_mobile,c.company_address,c.`status`,c.created_at,c.updated_at, CONCAT(u.first_name,' ',u.last_name) AS owner_name, CONCAT(cu.first_name,' ',cu.last_name) AS created_by,CONCAT(uu.first_name,' ',uu.last_name) AS updated_by 
        FROM companies c left JOIN users u ON c.company_id=u.company_id AND u.user_type = 'COMPANY'
         JOIN users cu ON c.created_by=cu.id JOIN users uu ON c.updated_by=uu.id";

        $model = DB::select($query);
        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('action', function ($model) {
                return '<i class="fas fa-edit custom_edit" data-id="' . $model->company_id . '"></i> <a href="'.route('config.company.login-as-company',[$model->company_id]).'" class="btn btn-block btn-success btn-sm">Login As Company</a>';
            })
            ->toJson();

        // return response()->json(['data' => DB::select($query)]);
    }


    public function loginAsCompany($company_id)
    {
        $superUser = auth()->user();
        $superUser->company_id = $company_id;
        $superUser->save();
        return redirect()->route('hris.branch.index')->with('success','Login as Company Successfully');
    }

    public function rebackAsSuperAdmin()
    {
        $superUser = auth()->user();
        $superUser->company_id = null;
        $superUser->save();
        return redirect()->route('config.company.index')->with('success','Back As Super Admin Successfully');
    }
}
