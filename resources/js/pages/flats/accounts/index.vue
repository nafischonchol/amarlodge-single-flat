<template>
    <main class="page-content">
        <div class="row">

            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Monthly') }} {{ translate('Summary') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Date') }}</th>
                                            <th>{{ translate('Total') }} {{ translate('Bill') }}</th>
                                            <th>{{ translate('Payment') }} {{ translate('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in data" :key="item.id">
                                            <td>
                                                <span>{{ item.date }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.total_bill_amount }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.total_pay_amount }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </main>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
import Errors from "@/errors/errors.js";

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
                .get('/flats-account-summary')
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    this.toast.error(error.response.data);
                });
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>
