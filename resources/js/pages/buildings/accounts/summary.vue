<template>
    <main class="page-content">
        <withdrawModal @form-submission-failed="handleWithdrawErrors" />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 my-3"> {{ formatDate(currentDate()) }}</div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-info">
                                <p>{{ translate('Total') }} {{ translate('Rent') }}</p>
                                <h4 class="text-info">{{ currency_symbol + " " + data.rent_amount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-info">
                                <p>{{ translate('Total') }} {{ translate('Maintenance Cost') }}</p>
                                <h4 class="text-info">{{ currency_symbol + " " + data.mc }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-info">
                                <p>{{ translate('Total') }} {{ translate('Utilities') }}</p>
                                <h4 class="text-info">{{ currency_symbol + " " + data.utility_amount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-primary">
                                <p>{{ translate('Cash') }} {{ translate('Paid') }}</p>
                                <h4 class="text-primary">{{ currency_symbol + " " + data.paidInfo.cash }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-primary">
                                <p>{{ translate('Mobile Bank') }} {{ translate('Paid') }}</p>
                                <h4 class="text-primary">{{ currency_symbol + " " + data.paidInfo.mobileBank }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-primary">
                                <p>{{ translate('Bank') }} {{ translate('Paid') }}</p>
                                <h4 class="text-primary">{{ currency_symbol + " " + data.paidInfo.traditionalBank }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text-center my-1">
                <h6>{{ translate('Current Amount You Have') }}
                </h6>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light">
                                <p>{{ translate('Cash') }}</p>
                                <h4 class="text-dark">{{ currency_symbol + " " + data.availableBalance.cash }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light">
                                <p>{{ translate('Mobile Bank') }}</p>
                                <h4 class="text-dark">{{ currency_symbol + " " + data.availableBalance.mobileBank }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light">
                                <p>{{ translate('Bank') }}</p>
                                <h4 class="text-dark">{{ currency_symbol + " " + data.availableBalance.traditionalBank }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <ul>
                    <li v-for="error in allErrors.errors" :key="error" class="text-danger mt-1">{{ error[0] }}</li>
                </ul>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text-center my-1">
                <button class="btn btn-primary p-2 m-2" @click="showWithdrawModal">{{ translate('Withdraw') }}</button>
            </div>
            <withdrawHistory />
        </div>
    </main>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
import Errors from "@/errors/errors.js";
import withdrawModal from "@/pages/buildings/accounts/withdrawModal.vue";
import withdrawHistory from "@/pages/buildings/accounts/withdrawHistory.vue";

export default {
    components: { withdrawModal, withdrawHistory },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            data: {},
        };
    },
    methods: {
        showWithdrawModal() {
            this.allErrors.allClear();
            $("#withdrawModal").modal("show");
        },
        handleWithdrawErrors(errors) {
            this.allErrors.record(errors);
        },
        fetchData() {
            axios
                .get('/buildings-account-summary')
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    },
    created() {
        this.fetchData();
    },
}
</script>
