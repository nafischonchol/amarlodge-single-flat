<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Rent') }} {{ translate('List') }} </h5>
                            <div class="ms-auto align-items-right">
                                <router-link :to="{ name: 'rent.add' }" class="btn btn-secondary m-1">
                                    {{ translate('Add') }} {{ translate('Rent') }}
                                </router-link>
                            </div>
                        </div>
                        <hr />
                        <DataTableSearch :perPage="perPage" :items="items" :fetchData="fetchData" />
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translate('Date') }}</th>
                                        <th>{{ translate('Building') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Flat') }} {{ translate('Name') }}</th>
                                        <th> {{ translate('Rent') }} {{ translate('Amount') }} </th>
                                        <th> {{ translate('Water') }} {{ translate('Bill') }} </th>
                                        <th> {{ translate('Gas') }} {{ translate('Bill') }} </th>
                                        <th> {{ translate('Security') }} {{ translate('Bill') }} </th>
                                        <th> {{ translate('Garbage') }} {{ translate('Bill') }} </th>
                                        <th> {{ translate('Service') }} {{ translate('Charge') }} </th>
                                        <th> {{ translate('Electric') }} {{ translate('Bill') }} </th>
                                        <th> {{ translate('Other') }} {{ translate('Bill') }} </th>
                                        <th> {{ translate('Total') }} {{ translate('Amount') }} </th>
                                        <th> {{ translate('Payment') }} {{ translate('Status') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data" :key="item.id">
                                        <template v-if="item.building && item.flat">
                                            <td>
                                                <span>{{ formatMonth(item.date) }}</span>
                                            </td>
                                            <td>
                                                <span v-if="item.building">{{ item.building.name }}</span>
                                            </td>
                                            <td>
                                                <span v-if="item.flat">{{ item.flat.name }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.rent_amount }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.water_bill }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.gas_bill }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.security_bill }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.garbage_bill }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.service_charge }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.electric_bill }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + item.other_bill }}</span>
                                            </td>
                                            <td>
                                                <span>{{ currency_symbol + " " + totalAmount(item) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ paymentStatus(item.status) }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3 fs-6">
                                                    <router-link :to="{ name: 'rent.invoice', params: { id: item.id } }"
                                                        class="text-secondary">
                                                        <span
                                                            class="material-symbols-outlined google-icon">text_snippet</span>
                                                    </router-link>

                                                    <router-link :to="{ name: 'rent.edit', params: { id: item.id } }"
                                                        class="text-warning"><span
                                                            class="material-symbols-outlined google-icon"
                                                            role="button">edit_square</span></router-link>
                                                </div>
                                            </td>
                                        </template>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="11" class="text-right">{{ translate('Total') }}</th>
                                        <th>{{ currency_symbol + " " + grossTotal() }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{ translate('Showing') }} {{ paginate.from }} {{ translate('to') }} {{ paginate.to }} {{
                                    translate('of') }} {{ paginate.total }}
                                {{ translate('entries') }} </div>
                            <div>
                                <pagination :data="paginate" @pagination-change-page="fetchData" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end row-->
    </main>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
import DataTableSearch from "@/components/DataTableSearch.vue"

export default {
    components: { DataTableSearch },
    data() {
        return {
            toast: useToast(),
            data: [],
            paginate: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        };
    },

    methods: {
        grossTotal() {
            let total = 0;

            for (const item of this.data) {
                total += this.totalAmount(item);
            }

            return total;
        },
        totalAmount(item) {
            const billFields = this.utilityAndRentField();
            return billFields.reduce((acc, field) => acc + item[field], 0);
        },
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/rents', {
                    params: {
                        page,
                        per_page: perPage,
                        search,
                    }
                })
                .then((response) => {
                    this.data = response.data.data;
                    this.paginate = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },

    mounted() {
        this.fetchData(1, this.perPage);

    },
};
</script>
