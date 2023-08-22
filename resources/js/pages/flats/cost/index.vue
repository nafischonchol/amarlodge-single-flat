<template>
    <main class="page-content">
        <div class="row">
            <DeleteModal modalId="rowDelete" :onDelete="deleteRow" />
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Cost') }} {{ translate('List') }} </h5>
                            <div class="ms-auto align-items-right">
                                <router-link :to="{ name: 'flat.cost.add' }" class="btn btn-secondary m-1">
                                    {{ translate('New') }} {{ translate('Cost') }}
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
                                        <!-- <th>Serial</th> -->
                                        <th>{{ translate('Date') }}</th>
                                        <th>{{ translate('Cause') }}</th>
                                        <th>{{ translate('Amount') }}</th>
                                        <th>{{ translate('Payment Method') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data" :key="item.id">
                                        <td>
                                            <span>{{ item.date }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.cause }}</span>
                                        </td>
                                        <td>
                                            <span>{{ currency_symbol + " " + item.amount }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.payment_method }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <router-link :to="{ name: 'flat.cost.edit', params: { id: item.id } }"
                                                    class="text-warning">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">edit_square</span>
                                                </router-link>
                                                <a @click="deleteConfirmation(item.id)" class="text-danger">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">delete</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
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
import Breadcrumb from "@/components/breadcrumb.vue";
import DeleteModal from "@/components/deleteModal.vue";
import DataTableSearch from "@/components/DataTableSearch.vue";

export default {
    components: { Breadcrumb, DeleteModal, DataTableSearch },
    data() {
        return {
            toast: useToast(),
            data: [],
            paginate: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
            selectedStaff: null, // Store the selected staff object
            staffToDelete: null, // Store the staff ID to delete
            rowToDelete: null

        };
    },
    methods: {
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/flat-costs', {
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
                    this.toast.error(error.response.data);
                });
        },

        deleteConfirmation(id) {
            this.rowToDelete = id;
            $("#rowDelete").modal("show");
        },
        deleteRow() {
            if (!this.rowToDelete) return;

            axios
                .delete(`/flat-costs/${this.rowToDelete}`)
                .then((response) => {
                    this.toast.success(response.data);
                    this.fetchData();
                })
                .catch((error) => {
                    console.error(error);

                })
                .finally(() => {

                });
        },
    },

    mounted() {
        this.fetchData(1, this.per_page);
    },
};
</script>
