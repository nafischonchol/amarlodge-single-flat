<template>
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden radius-10 min-height">
                <div class="card-body p-2 bg-light-info">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3 ">
                            <p> {{ translate('Total') }} {{ translate('Building') }}</p>
                            <h4 class="text-info">{{ data.total_building }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                house_siding
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
                        <div class="w-100 p-3 ">
                            <p> {{ translate('Total') }} {{ translate('Flat') }}</p>
                            <h4 class="text-info">{{ data.total_flat }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                apartment
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
                        <div class="w-100 p-3 ">
                            <p>{{ translate('Total') }} {{ translate('Booked') }} {{ translate('Flat') }}</p>
                            <h4 class="text-info">{{ data.total_booked_flat }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                apartment
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
                        <div class="w-100 p-3 ">
                            <p>{{ translate('Total') }} {{ translate('Available') }} {{ translate('Flat') }}</p>
                            <h4 class="text-info">{{ data.total_available_flat }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                apartment
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
                        <div class="w-100 p-3 ">
                            <p>{{ translate('Total') }} {{ translate('Tenant') }}</p>
                            <h4 class="text-info">{{ data.total_tenant }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                group
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
                        <div class="w-100 p-3 ">
                            <p> {{ translate('This Month') }} {{ translate('Rent') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.current_month_rent }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
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
                        <div class="w-100 p-3 ">
                            <p> {{ translate('Due') }} {{ translate('Rent') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.total_due_rent }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
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
                        <div class="w-100 p-3 ">
                            <p>{{ translate('Total') }} {{ translate('Maintenance Cost') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.total_maintenance_cost }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
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
                        <div class="w-100 p-3 ">
                            <p>{{ translate('Today') }} {{ translate('Maintenance Cost') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.today_maintenance_cost }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
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
                        <div class="w-100 p-3 ">
                            <p> {{ translate('This Month') }} {{ translate('Maintenance Cost') }}</p>
                            <h4 class="text-info">{{ currency_symbol + " " + data.this_month_maintenance_cost }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
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
                        <div class="w-100 p-3 ">
                            <p>{{ translate('Total') }} {{ translate('Staff') }}</p>
                            <h4 class="text-info">{{ data.total_staff }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                person_apron
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
                        <div class="w-100 p-3 ">
                            <p>{{ translate('Total') }} {{ translate('Visitor') }}</p>
                            <h4 class="text-info">{{ data.total_visitor }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                nest_doorbell_visitor
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
                        <div class="w-100 p-3 ">
                            <p>{{ translate('Total') }} {{ translate('Complain') }}</p>
                            <h4 class="text-info">{{ data.total_complains }}</h4>
                        </div>
                        <div class="w-50  p-3 icon d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined dashboard-icon">
                                forum
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-6">
                <div class="card overflow-hidden radius-10 min-height">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-9 overflow-hidden">
                            <div class="w-100 p-3 ">
                                <Chart :labels="chartLabels" :data="chartData" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <strong>{{ translate('Take ShortCut') }}</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <router-link :to="{ name: 'rent.add' }" class="btn btn-block btn-social btn-info">
                            <span class="material-symbols-outlined">
                                autorenew
                            </span> <span>{{ translate('Generate') }} {{
                                translate('Rent') }}</span>
                        </router-link>


                        <router-link :to="{ name: 'building.accounts.summary' }"
                            class="btn btn-block btn-social btn-primary">
                            <span class="material-symbols-outlined">
                                account_balance
                            </span> {{ translate('Accounts') }} {{ translate('Summary') }}
                        </router-link>
                        <router-link :to="{ name: 'maintenance.list' }" class="btn btn-block btn-social btn-secondary">
                            <span class="material-symbols-outlined">
                                payments
                            </span> {{ translate('Maintenance Cost') }}
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
import Chart from "@/components/lineChart.vue";
import "@/components/assets/dashboard.css";

export default {
    components: {
        Chart
    },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            data: {},
            chartLabels: [],
            chartData: []
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
        fetchChartData() {
            axios
                .get('/rent-data-monthly')
                .then((response) => {
                    this.chartLabels = response.data.chartLabels;
                    this.chartData = [{
                        label: this.translate('Monthly Rent'),
                        backgroundColor: '#f87979',
                        data: response.data.chartData
                    }];
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    created() {
        this.fetchData();
        this.fetchChartData();
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
