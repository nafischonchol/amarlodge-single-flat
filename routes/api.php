<?php

use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillController;
use App\Http\Controllers\Api\BuildingAccountController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\CommitteController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ComplainController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FlatAccountController;
use App\Http\Controllers\Api\FlatController;
use App\Http\Controllers\Api\FlatCostController;
use App\Http\Controllers\Api\GeneralSettingController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\MaintenanceCostController;
use App\Http\Controllers\Api\MeetingController;
use App\Http\Controllers\Api\MoveOutRequestController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Rbac\RoleController;
use App\Http\Controllers\Api\Rbac\RolePermissionConctroller;
use App\Http\Controllers\Api\Rbac\UserAccessController;
use App\Http\Controllers\Api\Rbac\UserController;
use App\Http\Controllers\Api\RentController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\Setting\BankSetupController;
use App\Http\Controllers\Api\Setting\UtilitySetupController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\TenantAdvanedMoneyController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\TenantInformationController;
use App\Http\Controllers\Api\VisitorController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::get('dashboard-summary', [DashboardController::class, 'summary']);
        Route::get('rent-data-monthly', [DashboardController::class, 'monthlyRentData']);

        //staffs
        Route::get('staffs/export-csv', [StaffController::class, 'exportCsv'])->name('staffs.export.csv');
        Route::get('staffs/all', [StaffController::class, 'all'])->name('staffs.all');
        Route::apiResource('staffs', StaffController::class);

        //flats
        Route::prefix('flats')->group(function () {
            Route::get('export-csv', [FlatController::class, 'exportCsv'])->name('flats.export.csv');
            Route::get('building-wise/{building_id}', [FlatController::class, 'buildingWiseFlat'])->name('flats.building.wise');
            Route::get('available/building-wise/{building_id?}', [FlatController::class, 'availableFlat'])->name('available.flats.building.wise');
            Route::get('available/{building_id?}', [FlatController::class, 'availableFlat']);

            Route::get('available-and-selected/building-wise/{building_id}/{tenant_id}', [FlatController::class, 'buildingWiseAvailableAndSelect']);
            Route::get('building-wise/booked/{building_id}', [FlatController::class, 'buildingWiseBooked']);

            Route::get('upcoming-availability/{building_id?}', [FlatController::class, 'upcomingAvailability']);
        });
        Route::apiResource('flats', FlatController::class);

        Route::group(['middleware' => 'tenant'], function () {
            //flats cost
            Route::apiResource('flat-costs', FlatCostController::class);
            //bills
            Route::apiResource('flat-bills', BillController::class)->only(['index']);
            Route::get('flat-bills/pay-history', [BillController::class, 'payBillHistory']);
            Route::get('flat-bills/pay-history-details/{payment_id}', [BillController::class, 'PayBillHistoryDetails']);
            Route::post('flat-bills-pay', [BillController::class, 'payBill']);

            Route::get('my-advanced-money', [TenantAdvanedMoneyController::class, 'myAdvancedMoney']);
            //flats account
            Route::apiResource('flats-account-summary', FlatAccountController::class)->only(['index', 'show']);
        });
        Route::get('advanced-money-history/{tenant_id}', [TenantAdvanedMoneyController::class, 'history']);

        Route::group(['middleware' => 'owner'], function () {
            //buildings
            Route::get('buildings/export-csv', [BuildingController::class, 'exportCsv'])->name('buildings.export.csv');

            //building accounts
            Route::get('payment-list-for-tenant', [BuildingAccountController::class, 'getAllPaymentsByTenant']);
            Route::put('update-payment-status/{payment_id}', [BuildingAccountController::class, 'updatePaymentStatus']);
            Route::get('payment-details/{payment_id}', [BuildingAccountController::class, 'paymentDetails']);
            Route::get('buildings-account-summary', [BuildingAccountController::class, 'summary']);
            Route::get('bank-type-wise-current-balance/{bank_type}', [BuildingAccountController::class, 'bankTypeWiseCurrentBalance']);
            Route::post('withdraw', [BuildingAccountController::class, 'withdraw']);
            Route::post('withdraw-history', [BuildingAccountController::class, 'withdrawHistory']);

            //tenants
            Route::get('tenants/export-csv', [TenantController::class, 'exportCsv'])->name('tenants.export.csv');
            Route::apiResource('tenants', TenantController::class);

            //move out
            Route::put('tenant-move-out/{tenant_id}', [MoveOutRequestController::class, 'tenantMoveOut']);
            Route::get('move-out-list', [MoveOutRequestController::class, 'moveOutList']);

            // move out request
            Route::put('update-move-out-request-status/{move_out_id}', [MoveOutRequestController::class, 'updateStatus']);

            //committe
            Route::apiResource('management-committe', CommitteController::class);

            //meeting
            Route::apiResource('meeting', MeetingController::class);
        });

        Route::prefix('notifications')->group(function () {

            Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
            Route::get('unread', [NotificationController::class, 'unread']);
            Route::post('/mark-as-read', [NotificationController::class, 'markAsRead']);
        });

        Route::get('buildings/all', [BuildingController::class, 'all'])->name('buildings.all');
        //company
        Route::get('company-info', [CompanyController::class, 'show']);
        Route::put('company-info', [CompanyController::class, 'update']);

        // Route::apiResource('company-info', CompanyController::class)->only(['show', 'update']);

        //general-settings
        Route::get('general-settings/currency', [GeneralSettingController::class, 'generalSettingCurrency']);
        Route::put('general-settings/currency-update', [GeneralSettingController::class, 'currencyUpdate']);
        Route::get('general-settings/default-image', [GeneralSettingController::class, 'generalSettingDefaultImage']);
        Route::put('general-settings/default-image-update', [GeneralSettingController::class, 'setDefaultImage']);

        // language
        Route::get('language/all-codes', [LanguageController::class, 'allCodes']);
        Route::put('language/update-status', [LanguageController::class, 'updateStatus']);
        Route::put('language/update-default-status', [LanguageController::class, 'updateDefaultStatus']);
        Route::get('language/translate/{code}', [LanguageController::class, 'getTranslate']);
        Route::put('language/translate-submit/{code}', [LanguageController::class, 'translateSubmit']);
        Route::put('language/translate-key-remove/{code}', [LanguageController::class, 'translate_key_remove']);
        Route::get('language/active-list', [LanguageController::class, 'activeList']);
        Route::get('language/translations/{code}', [LanguageController::class, 'translations']);
        Route::apiResource('language', LanguageController::class);

        //move out request
        Route::apiResource('move-out-request', MoveOutRequestController::class)->only(['index', 'store']);

        //visitors
        Route::get('visitors/export-csv', [VisitorController::class, 'exportCsv'])->name('visitors.export.csv');
        Route::apiResource('visitors', VisitorController::class);
        Route::apiResource('buildings', BuildingController::class);

        //notice
        Route::apiResource('notices', NoticeController::class);

        //complain
        Route::apiResource('complains', ComplainController::class);

        //maintenance cost
        Route::apiResource('maintenance-costs', MaintenanceCostController::class);

        //tenant information
        Route::apiResource('tenant-informations', TenantInformationController::class);

        //rent
        Route::get('rents-invoice/{rent_id}', [RentController::class, 'invoiceInfo']);
        Route::apiResource('rents', RentController::class);

        //user info
        Route::get('user-info', [UserController::class, 'userInfo']);
        Route::put('profile-update', [UserController::class, 'profileUpdate']);
        Route::put('password-update', [UserController::class, 'passwordUpdate']);

        //activity
        Route::get('activity-log', [ActivityLogController::class, 'index']);

        Route::group(['prefix' => 'setting'], function () {
            //utility setup
            Route::get('utility/building-wise/{building_id}', [UtilitySetupController::class, 'buildingWise']);
            Route::apiResource('utility-setups', UtilitySetupController::class);
            //bank setup
            Route::get('bank-setup/all', [BankSetupController::class, 'all']);
            Route::apiResource('bank-setup', BankSetupController::class);
        });

        Route::group(['prefix' => 'rbac'], function () {
            //roles
            Route::get('roles/all', [RoleController::class, 'all'])->name('roles.all');
            Route::resource('roles', RoleController::class);
            //users
            Route::get('users/all', [UserController::class, 'all'])->name('users.all');
            Route::resource('users', UserController::class);
            Route::get('roles-permissions/{role_id}', [RolePermissionConctroller::class, 'getPermissions']);
            Route::get('users-permissions', [RolePermissionConctroller::class, 'getUserPermissions']);
            Route::post('roles-permissions', [RolePermissionConctroller::class, 'store']);
            Route::resource('user-access', UserAccessController::class)->only(['store']);
        });
        Route::group(['prefix' => 'report'], function () {
            Route::post('rental', [ReportController::class, 'rental']);
            Route::post('maintenance', [ReportController::class, 'maintenance']);
            Route::post('visitor', [ReportController::class, 'visitor']);
            Route::post('complain', [ReportController::class, 'complain']);
        });

        // Route::post('/roles-permissions', [RolePermissionController::class, 'create']);
    });
});
