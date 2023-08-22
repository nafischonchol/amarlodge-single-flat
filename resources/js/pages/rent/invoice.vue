<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-6 col-md-8 mx-auto mt-4">
                <div class="page-info">
                    <h4 class="text-center mb-5"><u>{{ translate('Rent') }} {{ translate('Invoice') }}</u></h4>
                    <h4 class="text-right mb-4"><button class="btn btn-info" @click="printInvoice">{{ translate('Print')
                    }}</button></h4>
                </div>
                <div class="card">
                    <div class="card-body mt-4 px-5 print-div" id="print-div">
                        <div class="row">
                            <div class="text-center" v-if="data.building">
                                <h5 class="invoice-h5">{{
                                    data.building.name }}</h5>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-md-6" v-if="data.building">
                                {{ data.building.full_address }}<br>
                                {{ translate('Contact') }} {{ translate('Name') }}: {{ data.building.contact_name }}<br>
                                {{ translate('Mobile') }}: {{ data.building.contact_number }}<br>
                            </div>
                            <div class="col-md-6 text-right" v-if="data.flat">
                                <template v-if="data.tenant">
                                    {{ data.tenant.name }} <br>
                                    <span v-if="data.tenant.mobile">Phone: {{ data.tenant.mobile }} </span><br>
                                </template>
                                {{ translate('Flat') }}: {{ data.flat.name }} <br>
                                {{ translate('Bill') }} {{ translate('Month') }}: {{ formatMonth(data.date) }} <br>
                                <span v-if="data.payment_info"> Payment Date: {{ formatDate(data.payment_info.date)
                                }}</span>
                            </div>
                        </div>
                        <table class="table mb-5">
                            <thead>
                                <tr class="bg-secondary bg-light">
                                    <th class="text-left"> {{ translate('Bill') }} {{ translate('Details') }}</th>
                                    <th class="text-right">{{ translate('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">Home Rent</td>
                                    <td class="text-right">{{ data.rent_amount }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Water Bill</td>
                                    <td class="text-right">{{ data.water_bill }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Gas Bill</td>
                                    <td class="text-right">{{ data.gas_bill }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Security Bill</td>
                                    <td class="text-right">{{ data.security_bill }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Garbage Bill</td>
                                    <td class="text-right">{{ data.garbage_bill }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Service Charge</td>
                                    <td class="text-right">{{ data.service_charge }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Electric Bill</td>
                                    <td class="text-right">{{ data.electric_bill }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Other Bill</td>
                                    <td class="text-right">{{ data.other_bill }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-left">{{ translate('Total') }}:</th>
                                    <th class="text-right">{{ totalAmount() }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row signature-margin">
                            <div class="col-md-4 ">
                                <span>{{ translate('Signature') }} ------------------</span>
                            </div>
                            <div class="col-md-4">
                                <p> {{ translate('Payment') }} {{ translate('Method') }}: <span v-if="data.payment_info">{{
                                    data.payment_info.payment_method
                                }}</span>
                                    <span v-else>Unpaid</span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p>{{ translate('Payment') }} {{ translate('Status') }} : {{ paymentStatus(data.status) }}
                                </p>
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
import { useToast } from "vue-toastification";

export default {
    data() {
        return {
            toast: useToast(),
            data: [],
            routeId: this.$route.params.id,
        };
    },

    methods: {
        printInvoice() {
            const element = document.getElementById('print-div');
            this.print(element)
        },
        totalAmount() {
            const billFields = this.utilityAndRentField();
            return billFields.reduce((acc, field) => acc + this.data[field], 0);
        },
        fetchData() {
            axios
                .get(`/rents-invoice/${this.routeId}`,)
                .then((response) => {
                    this.data = response.data;
                    console.log(this.data.tenant.mobile)
                    // console.log(this.data)
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


