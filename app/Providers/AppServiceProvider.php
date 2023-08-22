<?php

namespace App\Providers;

use App\Models\AccountBalance;
use App\Models\BankSetup;
use App\Models\Building;
use App\Models\Committe;
use App\Models\Complain;
use App\Models\DueAmount;
use App\Models\Flat;
use App\Models\FlatCost;
use App\Models\GeneralSetting;
use App\Models\MaintenanceCost;
use App\Models\Meeting;
use App\Models\MoveOutHistory;
use App\Models\MoveOutRequest;
use App\Models\Notice;
use App\Models\PaymentBill;
use App\Models\Rent;
use App\Models\RoleHasPermission;
use App\Models\Staff;
use App\Models\Tenant;
use App\Models\TenantAdvancedAmount;
use App\Models\TenantFamilyMember;
use App\Models\TenantInformation;
use App\Models\User;
use App\Models\UtilitySetup;
use App\Models\Visitor;
use App\Observers\GlobalObserver;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        //global observers
        AccountBalance::observe(GlobalObserver::class);
        BankSetup::observe(GlobalObserver::class);
        Building::observe(GlobalObserver::class);
        Committe::observe(GlobalObserver::class);
        Complain::observe(GlobalObserver::class);
        DueAmount::observe(GlobalObserver::class);
        Flat::observe(GlobalObserver::class);
        FlatCost::observe(GlobalObserver::class);
        GeneralSetting::observe(GlobalObserver::class);
        MaintenanceCost::observe(GlobalObserver::class);
        Meeting::observe(GlobalObserver::class);
        MoveOutHistory::observe(GlobalObserver::class);
        MoveOutRequest::observe(GlobalObserver::class);
        Notice::observe(GlobalObserver::class);
        PaymentBill::observe(GlobalObserver::class);
        Rent::observe(GlobalObserver::class);
        Staff::observe(GlobalObserver::class);
        Tenant::observe(GlobalObserver::class);
        TenantAdvancedAmount::observe(GlobalObserver::class);
        TenantFamilyMember::observe(GlobalObserver::class);
        TenantInformation::observe(GlobalObserver::class);
        User::observe(GlobalObserver::class);
        UtilitySetup::observe(GlobalObserver::class);
        Visitor::observe(GlobalObserver::class);
        Role::observe(GlobalObserver::class);
        RoleHasPermission::observe(GlobalObserver::class);
    }
}
