<template>
    <main class="page-content">
        <div class="row">

            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Bill') }} {{ translate('List') }} </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Select') }}</th>
                                            <th>{{ translate('Date') }}</th>
                                            <th>{{ translate('Title') }}</th>
                                            <th>{{ translate('Type') }}</th>
                                            <th>{{ translate('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="data.due_bills && data.due_bills.length > 0">

                                            <td colspan="5" class="bg-info text-center text-light">
                                                {{ translate('Previous Bills') }}
                                            </td>
                                        </tr>

                                        <tr v-for="item in data.due_bills" :key="item.id">
                                            <td>
                                                <input type="checkbox" :value="item.id" v-model="checkedBills" />
                                            </td>
                                            <td>
                                                <span>{{ formatDate(item.date) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ item.title }}</span>
                                            </td>
                                            <td>
                                                <span>{{ item.type }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.amount }}</span>
                                            </td>
                                        </tr>
                                        <tr v-if="data.current_bills && data.current_bills.length > 0">
                                            <td colspan=" 5" class="bg-info text-center text-light">
                                                {{ translate('Current Bills') }}
                                            </td>
                                        </tr>
                                        <tr v-for="     item      in      data.current_bills     " :key="item.id">
                                            <td>
                                                <input type="checkbox" :value="item.id" v-model="checkedBills" />
                                            </td>
                                            <td>
                                                <span>{{ formatDate(item.date) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ item.title }}</span>
                                            </td>
                                            <td>
                                                <span>{{ item.type }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.amount }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">{{ translate('Total') }}</td>
                                            <td>{{ currency_symbol + " " + totalAmount }}</td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                            <span v-if="allErrors.has('checked_bills')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="allErrors.get('checked_bills')"></span>
                        </div>
                        <PayBillForm :prop_total_amount="totalAmount" :prop_checked_bills="checkedBills" />
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
import PayBillForm from "@/pages/flats/bills/pay-bill-form.vue";

export default {
    components: { PayBillForm },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            data: {},
            checkedBills: [],
            totalAmount: 0,
        };
    },
    methods: {
        calculateTotalAmount(checkedBills) {
            let total = 0;
            for (const bill of this.data.due_bills) {
                if (checkedBills.includes(bill.id)) {
                    total += bill.amount;
                }
            }
            for (const bill of this.data.current_bills) {
                if (checkedBills.includes(bill.id)) {
                    total += bill.amount;
                }
            }
            return total.toFixed(2);
        },
        fetchData() {
            axios
                .get('/flat-bills')
                .then((response) => {
                    this.data = response.data;
                    let due_bills = response.data.due_bills.map((bill) => bill.id);
                    let current_bills = response.data.current_bills.map((bill) => bill.id);
                    this.checkedBills.push(...current_bills);
                    this.checkedBills.push(...due_bills);
                })
                .catch((error) => {
                    this.toast.error(error.response.data);
                });
        },

    },

    watch: {
        checkedBills: {
            handler(newCheckedBills) {
                this.totalAmount = this.calculateTotalAmount(newCheckedBills);
            },
            deep: true,
        },
    },
    mounted() {
        this.fetchData();

    },
};
</script>
