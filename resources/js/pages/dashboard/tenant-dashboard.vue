<template>
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Total') }} {{ translate('Cost') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.total_cost }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                card_travel
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Total') }} {{ translate('Maintenance Cost') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.total_maintenance_cost }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                construction
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Today') }} {{ translate('Maintenance Cost') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.today_maintenance_cost }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                construction
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('This Month') }} {{ translate('Maintenance Cost') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.this_month_maintenance_cost }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                construction
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Total') }} {{ translate('Complain') }}</p>
                            <h4 class="text-info">{{ data.total_complains }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                forum
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Total') }} {{ translate('Rent') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.total_rent }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                payments
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Total') }} {{ translate('Due') }} {{ translate('Rent') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.total_due_rent }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                payments
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Total') }} {{ translate('Due') }} {{ translate('Bill') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.total_due_bill }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                cases
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Total') }} {{ translate('Paid') }} {{ translate('Bill') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.today_paid_bill }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                cases
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3">
                            <p>{{ translate('Total') }} {{ translate('Utility Bill') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.total_utility_bill }}</h4>
                        </div>
                        <div class="w-50 p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                cases
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <strong>{{ translate('Take ShortCut') }}</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <router-link :to="{ name: 'notice.list' }" class="btn btn-block btn-social btn-info">
                            <span class="material-symbols-outlined">
                                autorenew
                            </span> {{ translate('Notice') }} {{ translate('List') }}
                        </router-link>
                        <router-link :to="{
                            name: 'complain.list'
                        }" class="btn btn-block btn-social btn-primary">
                            <span class="material-symbols-outlined">
                                account_balance
                            </span> {{ translate('Complain') }}
                        </router-link>
                        <router-link :to="{ name: 'flats.bill.list' }" class="btn btn-block btn-social btn-secondary">
                            <span class="material-symbols-outlined">
                                payments
                            </span> {{ translate('Due') }} {{ translate('Bill') }}
                        </router-link>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
import Errors from "@/errors/errors.js";
import "@/components/assets/dashboard.css";

export default {
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            data: {},
        };
    },
    methods: {
        fetchData() {
            axios
                .get('/dashboard-summary')
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    created() {
        this.fetchData();
    }
}
</script>

<style scoped>
.dashboard-icon {
    font-size: 60px;
}

.min-height {
    min-height: 150px;
}
</style>
