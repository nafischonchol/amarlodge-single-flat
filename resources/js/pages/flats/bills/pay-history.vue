<template>
    <main class="page-content">
        <div class="row">

            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Payment') }} {{ translate('History') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Date') }}</th>
                                            <th>{{ translate('Payment Method') }}</th>
                                            <th>{{ translate('Total') }} {{ translate('Amount') }}</th>
                                            <th>{{ translate('Discount') }} {{ translate('Amount') }}</th>
                                            <th>{{ translate('Paid') }} {{ translate('Amount') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Details') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in data" :key="item.id">
                                            <td>
                                                <span>{{ formatDate(item.date) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ item.payment_method }}</span>
                                                <span v-if="isTraditionalBank(item)">{{ "(" +
                                                    item.from_account + "," +
                                                    item.to_account + ")" }}</span>
                                                <span v-if="isMobileBank(item)">{{ "(" +
                                                    item.receiver_number + "," +
                                                    item.transaction_id + ")" }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.total_amount }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.discount_amount }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.pay_amount }}</span>
                                            </td>
                                            <td>
                                                <span>{{ getStatus(item.status) }}</span>
                                            </td>
                                            <td>
                                                <router-link
                                                    :to="{ name: 'flats.bill.pay.history.details', params: { id: item.id } }"
                                                    class="text-primary">
                                                    <span class="material-symbols-outlined google-icon visibility"
                                                        role="button">visibility</span>
                                                </router-link>
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
        };
    },
    methods: {
        isTraditionalBank(item) {
            return item.from_account && item.to_account;
        },
        isMobileBank(item) {
            return item.receiver_number && item.transaction_id;
        },
        getStatus(status) {
            if (status === 3)
                return 'Cancel';
            else if (status === 2) {
                return 'Pending';
            } else if (status === 1) {
                return 'Confirm';
            } else if (status === 0) {
                return 'Created';
            } else {
                return 'Unknown'; // optional: handle any other status values
            }
        },
        formatDate(date) {
            return moment(date).format('DD MMMM, YYYY');
        },
        fetchData() {
            axios
                .get('/flat-bills/pay-history')
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
