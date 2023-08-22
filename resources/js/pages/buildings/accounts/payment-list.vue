<template>
    <main class="page-content">
        <div class="row">

            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Payment') }} {{ translate('List') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Date') }}</th>
                                            <th>{{ translate('Building') }} {{ translate('Name') }}</th>
                                            <th>{{ translate('Flat') }} {{ translate('Name') }}</th>
                                            <th>{{ translate('Payment') }} {{ translate('Method') }}</th>
                                            <th> {{ translate('Total') }} {{ translate('Amount') }}</th>
                                            <th> {{ translate('Discount') }} {{ translate('Amount') }}</th>
                                            <th>{{ translate('Use Advanced Amount') }}</th>
                                            <th> {{ translate('Paid') }} {{ translate('Amount') }}</th>
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
                                                <span v-if="item.building">{{ item.building.name }}</span>
                                            </td>
                                            <td>
                                                <span v-if="item.flat">{{ item.flat.name }}</span>
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
                                                <span>{{ currency_symbol + " " + item.use_advanced_amount }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.pay_amount }}</span>
                                            </td>
                                            <td>
                                                <select v-model="item.status" class="form-control-overriding"
                                                    @change="submitForm(item)">
                                                    <option value="1">Confirm</option>
                                                    <option value="2">Pending</option>
                                                    <option value="3">Cancel</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <router-link :to="{ name: 'payment.details', params: { id: item.id } }">
                                                    <span class="material-symbols-outlined google-icon"
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
import Errors from "@/errors/errors.js";
import moment from 'moment';

export default {
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            data: [],
            form: {},
            currency_symbol: "৳",
        };
    },
    methods: {
        isTraditionalBank(item) {
            return item.from_account && item.to_account;
        },
        isMobileBank(item) {
            return item.receiver_number && item.transaction_id;
        },
        formatDate(date) {
            return moment(date).format('DD MMMM, YYYY');
        },
        fetchData() {
            axios
                .get('/payment-list-for-tenant')
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm(item) {
            this.form.status = item.status;
            axios
                .put(`/update-payment-status/${item.id}`, this.form)
                .then((response) => {
                    console.log(response.data);
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    if (error && error.response.status === 422) {
                        this.toast.error(error.response.data.status[0]);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },

    },
    mounted() {

        this.fetchData();
    },
};
</script>
