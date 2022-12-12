<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Config\UserController;
use App\Http\Controllers\Config\CompanyController;
use App\Http\Controllers\Config\RouteDetailController;
use App\Http\Controllers\Config\FeatureController;
use App\Http\Controllers\Config\PermissionController;
use App\Http\Controllers\Form\CommonFormController;
use App\Http\Controllers\HRIS\BranchController;
use App\Http\Controllers\HRIS\DepartmentController;
use App\Http\Controllers\HRIS\DesignationController;
use App\Http\Controllers\HRIS\EmployeeController;
use App\Http\Controllers\HRIS\OnboardingEmployeeController;
use App\Http\Controllers\HRIS\RoleController;
use App\Http\Controllers\HRIS\ShiftController;
use App\Http\Controllers\HRIS\UserController as HRISUserController;
use App\Http\Controllers\Inventory\Brand\BrandController;
use App\Http\Controllers\Inventory\Category\CategoryController;
use App\Http\Controllers\Inventory\Product\ProductController;
use App\Http\Controllers\Inventory\Supplier\SupplierController;
use App\Http\Controllers\Inventory\Unit\UnitController;
use App\Http\Controllers\LMS\Campaign\CampaignController;
use App\Http\Controllers\LMS\Registration\RegistrationController;
use App\Http\Controllers\Payroll\EmployeeAttendanceController;
use App\Http\Controllers\Payroll\LeaveTypeController;
use App\Http\Controllers\Setting\DatabaseBackupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/dashboard/index', function () {
//     return view('backend.dashboard.index');
// })->middleware(['auth'])->name('dashboard.index');

require __DIR__ . '/auth.php';
/**
 * --------------------------------------------
 *              Database Backup Stting
 * --------------------------------------------
 */
Route::get('setting/database/backup', [DatabaseBackupController::class, 'geDatabaseBackup'])->name('database.backup');//->middleware('permission:hris.user.list'); //ajax


/**
 * Routing For Configuration or Initial setup projects
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/index', function () {
        return view('backend.dashboard.index');
    })->name('config.dashboard.index')->middleware('permission:dashboard.view');
    Route::get('form/application/{form_name}', [CommonFormController::class, 'getFormApplication'])->name('form.application.index');//->middleware('permission:hris.user.list'); //ajax

    Route::post('form/application/store/{form_name}', [CommonFormController::class, 'storeFormApplication'])->name('form.application.store');//->middleware('permission:hris.user.list'); //ajax

    Route::get('form/builder/create', [CommonFormController::class, 'create'])->name('form.builder.create');//->middleware('permission:hris.user.list'); //ajax
    Route::post('form/builder/create', [CommonFormController::class, 'store'])->name('form.builder.store');//->middleware('permission:hris.user.list'); //ajax
    Route::get('form/builder/{form_name}', [CommonFormController::class, 'getFormBuilder'])->name('form.builder.index');//->middleware('permission:hris.user.list'); //ajax

});
Route::middleware(['auth'])->prefix('config')->group(function () {

    /**
     * --------------------------------------
     *      Features
     * --------------------------------------
     */
    Route::post('/feature/list', [FeatureController::class, 'list'])->name('config.feature.list')->middleware('permission:config.feature.view'); //ajax
    Route::get('/feature/index', [FeatureController::class, 'index'])->name('config.feature.index')->middleware('permission:config.feature.view'); //View
    Route::post('/feature/store', [FeatureController::class, 'store'])->name('config.feature.store')->middleware('permission:config.feature.create'); // Create ajax
    Route::post('/feature/edit', [FeatureController::class, 'edit'])->name('config.feature.edit')->middleware('permission:config.feature.edit'); //Edit ajax
    Route::post('/feature/update', [FeatureController::class, 'update'])->name('config.feature.update')->middleware('permission:config.feature.edit'); //ajax
    Route::post('/feature/delete', [FeatureController::class, 'delete'])->name('config.feature.delete')->middleware('permission:config.feature.delete'); // Delete ajax



    /**
     * --------------------------------------
     *      Config Users
     * --------------------------------------
     */
    Route::post('/user/list', [UserController::class, 'list'])->name('config.user.list')->middleware('permission:config.user.view'); //ajax
    Route::get('/user/index', [UserController::class, 'index'])->name('config.user.index')->middleware('permission:config.user.view'); //View
    Route::post('/user/store', [UserController::class, 'store'])->name('config.user.store')->middleware('permission:config.user.create'); // Create ajax
    Route::post('/user/edit', [UserController::class, 'edit'])->name('config.user.edit')->middleware('permission:config.user.edit'); //Edit ajax
    Route::post('/user/update', [UserController::class, 'update'])->name('config.user.update')->middleware('permission:config.user.edit'); //ajax
    Route::post('/user/delete', [UserController::class, 'delete'])->name('config.user.delete')->middleware('permission:config.user.delete'); // Delete ajax

    /**
     * --------------------------------------
     *      Companies
     * --------------------------------------
     */
    Route::post('/company/list', [CompanyController::class, 'list'])->name('config.company.list')->middleware('permission:config.company.view'); //ajax
    Route::get('/company/index', [companyController::class, 'index'])->name('config.company.index')->middleware('permission:config.company.view'); //View
    Route::get('/company/show', [companyController::class, 'show'])->name('config.company.show')->middleware('permission:config.company.show'); //Show
    Route::post('/company/store', [companyController::class, 'store'])->name('config.company.store')->middleware('permission:config.company.create'); // Create ajax
    Route::post('/company/edit', [companyController::class, 'edit'])->name('config.company.edit')->middleware('permission:config.company.edit'); //Edit ajax
    Route::post('/company/update', [companyController::class, 'update'])->name('config.company.update')->middleware('permission:config.company.edit'); //ajax
    Route::post('/company/delete', [companyController::class, 'delete'])->name('config.company.delete')->middleware('permission:config.company.delete'); // Delete ajax
    Route::get('/company/login-as-company/{company_id}', [companyController::class, 'loginAsCompany'])->name('config.company.login-as-company');//->middleware('permission:config.company.index'); //View

    Route::get('/company/back-to-super-admin', [companyController::class, 'rebackAsSuperAdmin'])->name('config.company.back-to-super-admin');



    /**
     * --------------------------------------
     *      Route Details
     * --------------------------------------
     */
    Route::post('/route/list', [RouteDetailController::class, 'routeList'])->name('config.route.list'); //ajax
    Route::get('/route/index', [RouteDetailController::class, 'index'])->name('config.route.index');
    Route::post('/route/store', [RouteDetailController::class, 'routeStore'])->name('config.route.store');
    Route::post('/route/edit/get', [RouteDetailController::class, 'getRouteEdit'])->name('config.route.get.edit.ajax');

    /**
     * --------------------------------------
     *      Route Details
     * --------------------------------------
     */
    Route::post('/permission/list', [permissionController::class, 'list'])->name('config.permission.list')->middleware('permission:config.permission.view'); //ajax
    Route::get('/permission/index', [permissionController::class, 'index'])->name('config.permission.index')->middleware('permission:config.permission.view'); //View
    Route::post('/permission/store', [permissionController::class, 'store'])->name('config.permission.store')->middleware('permission:config.permission.create'); // Create ajax
    Route::post('/permission/edit', [permissionController::class, 'edit'])->name('config.permission.edit')->middleware('permission:config.permission.edit'); //Edit ajax
    Route::post('/permission/update', [permissionController::class, 'update'])->name('config.permission.update')->middleware('permission:config.permission.edit'); //ajax
    Route::post('/permission/delete', [permissionController::class, 'delete'])->name('config.permission.delete')->middleware('permission:config.permission.delete'); // Delete ajax



});

/**
 * -----------------------------------------------------
 *          Routing For HRIS setup
 * ------------------------------------------------------
 */

Route::middleware(['auth'])->prefix('hris')->group(function () {

/**
     * --------------------------------------
     *      branch
     * --------------------------------------
     */
    Route::post('/branch/list', [BranchController::class, 'list'])->name('hris.branch.list')->middleware('permission:hris.branch.view'); //ajax
    Route::get('/branch/index', [BranchController::class, 'index'])->name('hris.branch.index')->middleware('permission:hris.branch.view'); //View
    Route::post('/branch/store', [BranchController::class, 'store'])->name('hris.branch.store')->middleware('permission:hris.branch.create'); // Create ajax
    Route::post('/branch/edit', [BranchController::class, 'edit'])->name('hris.branch.edit')->middleware('permission:hris.branch.edit'); //Edit ajax
    Route::post('/branch/update', [BranchController::class, 'update'])->name('hris.branch.update')->middleware('permission:hris.branch.edit'); //ajax
    Route::post('/branch/delete', [BranchController::class, 'delete'])->name('hris.branch.delete')->middleware('permission:hris.branch.delete'); // Delete ajax
    Route::get('/branch/login-as-branch/{branch_id}', [BranchController::class, 'loginAsBranch'])->name('hris.branch.login-as-branch');//->middleware('permission:config.branch.index'); //View
    Route::get('/branch/back-to-super-admin', [BranchController::class, 'rebackAsNormal'])->name('hris.branch.back-to-normal');

     /**
     * --------------------------------------
     *      Department
     * --------------------------------------
     */
    Route::post('/department/list', [DepartmentController::class, 'list'])->name('hris.department.list')->middleware('permission:hris.department.view'); //ajax
    Route::get('/department/index', [DepartmentController::class, 'index'])->name('hris.department.index')->middleware('permission:hris.department.view'); //View
    Route::post('/department/store', [DepartmentController::class, 'store'])->name('hris.department.store')->middleware('permission:hris.department.create'); // Create ajax
    Route::post('/department/edit', [DepartmentController::class, 'edit'])->name('hris.department.edit')->middleware('permission:hris.department.edit'); //Edit ajax
    Route::post('/department/update', [DepartmentController::class, 'update'])->name('hris.department.update')->middleware('permission:hris.department.edit'); //ajax
    Route::post('/department/delete', [DepartmentController::class, 'delete'])->name('hris.department.delete')->middleware('permission:hris.department.delete'); // Delete ajax

    /**
     * --------------------------------------
     *      Designation
     * --------------------------------------
     */
    Route::post('/designation/list', [DesignationController::class, 'list'])->name('hris.designation.list')->middleware('permission:hris.designation.view'); //ajax
    Route::get('/designation/index', [DesignationController::class, 'index'])->name('hris.designation.index')->middleware('permission:hris.designation.view'); //View
    Route::post('/designation/store', [DesignationController::class, 'store'])->name('hris.designation.store')->middleware('permission:hris.designation.create'); // Create ajax
    Route::post('/designation/edit', [DesignationController::class, 'edit'])->name('hris.designation.edit')->middleware('permission:hris.designation.edit'); //Edit ajax
    Route::post('/designation/update', [DesignationController::class, 'update'])->name('hris.designation.update')->middleware('permission:hris.designation.edit'); //ajax
    Route::post('/designation/delete', [DesignationController::class, 'delete'])->name('hris.designation.delete')->middleware('permission:hris.designation.delete'); // Delete ajax
    Route::post('/designation/by-deptid', [DesignationController::class, 'getDesignationByDeptId'])->name('hris.designation.by-deptid');

    /**
     * --------------------------------------
     *      Shifts
     * --------------------------------------
     */
    Route::post('/shift/list', [ShiftController::class, 'list'])->name('hris.shift.list')->middleware('permission:hris.shift.view'); //ajax
    Route::get('/shift/index', [ShiftController::class, 'index'])->name('hris.shift.index')->middleware('permission:hris.shift.view'); //View
    Route::post('/shift/store', [ShiftController::class, 'store'])->name('hris.shift.store')->middleware('permission:hris.shift.create'); // Create ajax
    Route::post('/shift/edit', [ShiftController::class, 'edit'])->name('hris.shift.edit')->middleware('permission:hris.shift.edit'); //Edit ajax
    Route::post('/shift/update', [ShiftController::class, 'update'])->name('hris.shift.update')->middleware('permission:hris.shift.edit'); //ajax
    Route::post('/shift/delete', [ShiftController::class, 'delete'])->name('hris.shift.delete')->middleware('permission:hris.shift.delete'); // Delete ajax

    /**
     * --------------------------------------
     *      Employee
     * --------------------------------------
     */
    Route::post('/employee/list', [EmployeeController::class, 'list'])->name('hris.employee.list')->middleware('permission:hris.employee.view'); //ajax
    Route::get('/employee/index', [EmployeeController::class, 'index'])->name('hris.employee.index')->middleware('permission:hris.employee.view'); //View
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('hris.employee.create')->middleware('permission:hris.employee.create'); //View

    Route::post('/employee/store', [EmployeeController::class, 'store'])->name('hris.employee.store')->middleware('permission:hris.employee.create'); // Create ajax
    Route::post('/employee/edit', [EmployeeController::class, 'edit'])->name('hris.employee.edit')->middleware('permission:hris.employee.edit'); //Edit ajax
    Route::post('/employee/update', [EmployeeController::class, 'update'])->name('hris.employee.update')->middleware('permission:hris.employee.edit'); //ajax
    Route::post('/employee/delete', [EmployeeController::class, 'delete'])->name('hris.employee.delete')->middleware('permission:hris.employee.delete'); // Delete ajax

    /**
     * --------------------------------------
     *      Role
     * --------------------------------------
     */
    Route::post('/role/list', [RoleController::class, 'list'])->name('hris.role.list')->middleware('permission:hris.role.view'); //ajax
    Route::get('/role/index', [RoleController::class, 'index'])->name('hris.role.index')->middleware('permission:hris.role.view'); //View
    Route::get('/role/create', [RoleController::class, 'create'])->name('hris.role.create')->middleware('permission:hris.role.create'); //Create
    Route::post('/role/store', [RoleController::class, 'store'])->name('hris.role.store')->middleware('permission:hris.role.create'); // Create ajax
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('hris.role.edit')->middleware('permission:hris.role.edit'); //Edit ajax
    Route::post('/role/update', [RoleController::class, 'update'])->name('hris.role.update')->middleware('permission:hris.role.edit'); //ajax
    Route::post('/role/delete', [RoleController::class, 'delete'])->name('hris.role.delete')->middleware('permission:hris.role.delete'); // Delete ajax

    /**
     * --------------------------------------
     *     For Company Users
     * --------------------------------------
     */
    Route::post('/user/list', [HRISUserController::class, 'list'])->name('hris.user.list')->middleware('permission:hris.user.view'); //ajax
    Route::get('/user/index', [HRISUserController::class, 'index'])->name('hris.user.index')->middleware('permission:hris.user.view'); //View
    Route::post('/user/store', [HRISUserController::class, 'store'])->name('hris.user.store')->middleware('permission:hris.user.create'); // Create ajax
    Route::post('/user/edit', [HRISUserController::class, 'edit'])->name('hris.user.edit')->middleware('permission:hris.user.edit'); //Edit ajax
    Route::post('/user/update', [HRISUserController::class, 'update'])->name('hris.user.update')->middleware('permission:hris.user.edit'); //ajax
    Route::post('/user/delete', [HRISUserController::class, 'delete'])->name('hris.user.delete')->middleware('permission:hris.user.delete'); // Delete ajax
    Route::get('/user/permission/{user_id}', [HRISUserController::class, 'userPermission'])->name('hris.user.permission')->middleware('permission:hris.user.permission'); // Edit User Permissions.
    Route::post('/user/permission/{user_id}', [HRISUserController::class, 'userPermissionPost'])->name('hris.user.permission')->middleware('permission:hris.user.permission'); // Edit User Permissions.

    /**
     * --------------------------------------
     *     For Company onboarding Employees
     * --------------------------------------
     */

    Route::post('/onboarding-employee/list', [OnboardingEmployeeController::class, 'list'])->name('hris.onboarding-employee.list')->middleware('permission:hris.onboarding-employee.view'); //ajax
    Route::get('/onboarding-employee/index', [OnboardingEmployeeController::class, 'index'])->name('hris.onboarding-employee.index')->middleware('permission:hris.onboarding-employee.view'); //View
    Route::post('/onboarding-employee/store', [OnboardingEmployeeController::class, 'store'])->name('hris.onboarding-employee.store')->middleware('permission:hris.onboarding-employee.create'); // Create ajax
    Route::post('/onboarding-employee/edit', [OnboardingEmployeeController::class, 'edit'])->name('hris.onboarding-employee.edit')->middleware('permission:hris.onboarding-employee.edit'); //Edit ajax
    Route::post('/onboarding-employee/update', [OnboardingEmployeeController::class, 'update'])->name('hris.onboarding-employee.update')->middleware('permission:hris.onboarding-employee.edit'); //ajax
    Route::post('/onboarding-employee/delete', [OnboardingEmployeeController::class, 'delete'])->name('hris.onboarding-employee.delete')->middleware('permission:hris.onboarding-employee.delete'); // Delete ajax

});

/**
 * -----------------------------------------------------
 *          Routing For Payroll Functionality
 * ------------------------------------------------------
 */

Route::middleware(['auth'])->prefix('payroll')->group(function () {

    /**
    * --------------------------------------
    *      Department
    * --------------------------------------
    */
    Route::post('/attendance/list', [EmployeeAttendanceController::class, 'list'])->name('payroll.attendance.list')->middleware('permission:payroll.attendance.view'); //ajax
    Route::get('/attendance/index', [EmployeeAttendanceController::class, 'index'])->name('payroll.attendance.index')->middleware('permission:payroll.attendance.view'); //View
    Route::post('/attendance/store', [EmployeeAttendanceController::class, 'store'])->name('payroll.attendance.store')->middleware('permission:payroll.attendance.create'); // Create ajax
    Route::post('/attendance/edit', [EmployeeAttendanceController::class, 'edit'])->name('payroll.attendance.edit')->middleware('permission:payroll.attendance.edit'); //Edit ajax
    Route::post('/attendance/update', [EmployeeAttendanceController::class, 'update'])->name('payroll.attendance.update')->middleware('permission:payroll.attendance.edit'); //ajax
    Route::post('/attendance/delete', [EmployeeAttendanceController::class, 'delete'])->name('payroll.attendance.delete')->middleware('permission:payroll.attendance.delete'); // Delete ajax
    Route::get('/attendance/report', [EmployeeAttendanceController::class, 'report'])->name('payroll.attendance.report.view')->middleware('permission:payroll.attendance.report.view'); //Report

 /**
     * --------------------------------------
     *      Leave Type
     * --------------------------------------
     */
    Route::post('/leave-type/list', [LeaveTypeController::class, 'list'])->name('payroll.leave-type.list')->middleware('permission:payroll.leave-type.view'); //ajax
    Route::get('/leave-type/index', [LeaveTypeController::class, 'index'])->name('payroll.leave-type.index')->middleware('permission:payroll.leave-type.view'); //View
    Route::post('/leave-type/store', [LeaveTypeController::class, 'store'])->name('payroll.leave-type.store')->middleware('permission:payroll.leave-type.create'); // Create ajax
    Route::post('/leave-type/edit', [LeaveTypeController::class, 'edit'])->name('payroll.leave-type.edit')->middleware('permission:payroll.leave-type.edit'); //Edit ajax
    Route::post('/leave-type/update', [LeaveTypeController::class, 'update'])->name('payroll.leave-type.update')->middleware('permission:payroll.leave-type.edit'); //ajax
    Route::post('/leave-type/delete', [LeaveTypeController::class, 'delete'])->name('payroll.leave-type.delete')->middleware('permission:payroll.leave-type.delete'); // Delete ajax





});

Route::middleware(['auth'])->prefix('lms')->group(function () {
/**
     * --------------------------------------
     *      Campagin
     * --------------------------------------
     */
    Route::get('/campaign/index', [CampaignController::class, 'index'])->name('lms.campaign.index'); //View
    Route::get('/campaign/create', [CampaignController::class, 'create'])->name('lms.campaign.create'); //View
    Route::post('/campaign/store', [CampaignController::class, 'store'])->name('lms.campaign.store'); // Create
    Route::put('/campaign/{campaign}', [CampaignController::class, 'update'])->name('lms.campaign.update');
    Route::get('/campaign/{campaign}/edit', [CampaignController::class, 'edit'])->name('lms.campaign.edit');
    Route::post('/campaign/delete', [CampaignController::class, 'delete'])->name('lms.campaign.delete'); // Delete ajax

    /**
     * --------------------------------------
     *      Campagin Type
     * --------------------------------------
     */
    Route::get('/registration/index', [RegistrationController::class, 'index'])->name('lms.registration.index'); //View
    Route::get('/registration/create', [RegistrationController::class, 'create'])->name('lms.registration.create'); //View
    Route::post('/registration/store', [RegistrationController::class, 'store'])->name('lms.registration.store'); // Create
    Route::put('/registration/{registration}', [RegistrationController::class, 'update'])->name('lms.registration.update');
    Route::get('/registration/{registration}/edit', [RegistrationController::class, 'edit'])->name('lms.registration.edit');
    Route::post('/registration/delete', [RegistrationController::class, 'delete'])->name('lms.registration.delete'); // Delete ajax
});

Route::middleware(['auth'])->prefix('inventory')->group(function () {
    /**
         * --------------------------------------
         *      Brand
         * --------------------------------------
         */
        Route::get('/brand/index', [BrandController::class, 'index'])->name('inventory.brand.index'); //View
        Route::get('brand-data', [BrandController::class, 'getAllData'])->name('inventory.brand.data');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('inventory.brand.create'); //View
        Route::post('/brand/store', [BrandController::class, 'store'])->name('inventory.brand.store'); // Create
        Route::put('/brand/{brand}', [BrandController::class, 'update'])->name('inventory.brand.update');
        Route::get('/brand/edit/{brand}', [BrandController::class, 'edit'])->name('inventory.brand.edit');
        Route::post('/brand/delete', [BrandController::class, 'delete'])->name('inventory.brand.delete'); // Delete ajax

        /**
         * --------------------------------------
         *      Category
         * --------------------------------------
         */
        Route::get('/category/index', [CategoryController::class, 'index'])->name('inventory.category.index'); //View
        Route::get('category-data', [CategoryController::class, 'getAllData'])->name('inventory.category.data');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('inventory.category.create'); //View
        Route::post('/category/store', [CategoryController::class, 'store'])->name('inventory.category.store'); // Create
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('inventory.category.update');
        Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('inventory.category.edit');
        Route::post('/category/delete', [CategoryController::class, 'delete'])->name('inventory.category.delete'); // Delete ajax


        /**
         * --------------------------------------
         *      Supplier
         * --------------------------------------
         */
        Route::get('/supplier/index', [SupplierController::class, 'index'])->name('inventory.supplier.index'); //View
        Route::get('supplier-data', [SupplierController::class, 'getAllData'])->name('inventory.supplier.data');
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('inventory.supplier.create'); //View
        Route::post('/supplier/store', [SupplierController::class, 'store'])->name('inventory.supplier.store'); // Create
        Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('inventory.supplier.update');
        Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->name('inventory.supplier.edit');
        Route::post('/supplier/delete', [SupplierController::class, 'delete'])->name('inventory.supplier.delete'); // Delete ajax

        /**
         * --------------------------------------
         *      Unit
         * --------------------------------------
         */
        Route::get('/unit/index', [UnitController::class, 'index'])->name('inventory.unit.index'); //View
        Route::get('unit-data', [UnitController::class, 'getAllData'])->name('inventory.unit.data');
        Route::get('/unit/create', [UnitController::class, 'create'])->name('inventory.unit.create'); //View
        Route::post('/unit/store', [UnitController::class, 'store'])->name('inventory.unit.store'); // Create
        Route::put('/unit/{unit}', [UnitController::class, 'update'])->name('inventory.unit.update');
        Route::get('/unit/{unit}/edit', [UnitController::class, 'edit'])->name('inventory.unit.edit');
        Route::post('/unit/delete', [UnitController::class, 'delete'])->name('inventory.unit.delete'); // Delete ajax
        Route::post('unitstore', [UnitController::class, 'unitStore'])->name('inventory.unit.unitStore');


        /**
         * --------------------------------------
         *      Product
         * --------------------------------------
         */
        Route::get('/product/index', [ProductController::class, 'index'])->name('inventory.product.index'); //View
        Route::get('product-data', [ProductController::class, 'getAllData'])->name('inventory.product.data');
        Route::get('/product/create', [ProductController::class, 'create'])->name('inventory.product.create'); //View
        Route::post('/product/store', [ProductController::class, 'store'])->name('inventory.product.store'); // Create
        Route::put('/product/{product}', [ProductController::class, 'update'])->name('inventory.product.update');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('inventory.product.edit');
        Route::post('/product/delete', [ProductController::class, 'delete'])->name('inventory.product.delete'); // Delete ajax
    });
