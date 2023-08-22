<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Rent Collection') }} {{
                                translate('Report') }}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12 col-md-12 col-sm-12">
                                <div class="card shadow-none bg-light border">
                                    <div class="card-body">
                                        <form class="row g-3" @keydown="allErrors.clear($event.target.name)"
                                            @submit.prevent="filterData">
                                            <BuildingFlatPicker :form="form" :allErrors="allErrors" />

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Month') }}</label>
                                                <input name="month" type="month" class="form-control"
                                                    v-model="form.month" />
                                                <span v-if="this.allErrors.has('month')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('month')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Payment') }}
                                                    {{ translate('Status') }}</label>
                                                <select name="payment_status" class="form-control"
                                                    v-model="form.payment_status">
                                                    <option value="">{{ translate('Choose') }}</option>
                                                    <option value="0">Due</option>
                                                    <option value="1">Paid</option>
                                                    <option value="2">Payment Pending</option>
                                                </select>
                                                <span v-if="this.allErrors.has('payment_status')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('payment_status')">
                                                </span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit">
                                                    {{ translate('Submit') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" v-if="data.length > 0">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-secondary" @click="printReport">
                                <span class="material-symbols-outlined">print</span>
                            </button>
                        </div>
                        <div id="print-div">
                            <h5 class="text-center my-1">{{ translate('Rent Collection') }} {{
                                translate('Report') }}</h5>
                            <div class="table-responsive">
                                <table class="table align-middle table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Building') }}</th>
                                            <th>{{ translate('Flat') }}</th>
                                            <th>{{ translate('Date') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Rent') }} {{ translate('Amount') }}</th>
                                            <th>{{ translate('Total') }} {{ translate('Utilities') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in  data " :key="item.id">
                                            <td>
                                                <span>{{ item.building.name }}</span>
                                            </td>
                                            <td>
                                                <span>{{ item.flat.name }}</span>
                                            </td>
                                            <td>
                                                <span>{{ formatMonth(item.date) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ paymentStatus(item.status) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.rent_amount }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + calculateUtility(item) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">{{ translate('Total') }}</th>
                                            <th>{{ currency_symbol + " " + calculateTotalRent }}</th>
                                            <th>{{ currency_symbol + " " + calculateTotalUtility() }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "@/axios-config";
import Errors from "@/errors/errors.js";
import { useToast } from "vue-toastification";
import BuildingFlatPicker from "@/components/BuildingFlatPicker.vue";

export default {
    components: { BuildingFlatPicker },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                building_id: "",
                flat_id: "",
                month: null,
                payment_status: "",
            },
            buildingList: [],
            flatList: [],
            data: []
        };
    },
    computed: {
        calculateTotalRent() {
            return this.data.reduce((acc, item) => acc + item.rent_amount, 0);
        },
    },
    methods:
    {
        printReport() {
            const element = document.getElementById('print-div');
            this.print(element)
        },

        calculateUtility(item) {
            const billFields = this.utilityField();
            return billFields.reduce((acc, field) => acc + (item[field] || 0), 0);
        },
        calculateTotalUtility() {
            const billFields = this.utilityField();
            return this.data.reduce((acc, item) => acc + this.calculateUtility(item), 0);
        },
        filterData() {
            this.loader(true)
            axios
                .post("/report/rental", this.form)
                .then((response) => {
                    this.loader(false)
                    this.data = response.data;
                    if (this.data.length > 0)
                        this.toast.success("Show Report");
                    else
                        this.toast.warning("No data found!");

                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
    },

};
</script>
