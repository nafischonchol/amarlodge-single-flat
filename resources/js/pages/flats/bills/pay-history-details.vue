<template>
    <main class="page-content">
        <div class="row">

            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Payment') }} {{ translate('Details') }}
                            </h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'flats.bill.pay.history' }" class="btn btn-secondary m-1">
                                    {{ translate('Back') }}
                                </router-link>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped">
                                    <thead>
                                        <tr>
                                            <th> {{ translate('Bill') }} {{ translate('Date') }}</th>
                                            <th>{{ translate('Bill') }} {{ translate('Title') }}</th>
                                            <th>{{ translate('Bill') }} {{ translate('Type') }}</th>
                                            <th> {{ translate('Bill') }} {{ translate('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in data" :key="item.id">
                                            <td>
                                                <span>{{ formatDate(item.bill.date) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ item.bill.title }}</span>
                                            </td>
                                            <td>
                                                <span>{{ item.bill.type }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.amount }}</span>
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
import moment from 'moment';

export default {
    data() {
        return {
            toast: useToast(),
            data: [],
            routerId: this.$route.params.id,
        };
    },
    methods: {

        formatDate(date) {
            return moment(date).format('DD MMMM, YYYY');
        },
        fetchData() {
            axios
                .get(`/flat-bills/pay-history-details/${this.routerId}`)
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>
