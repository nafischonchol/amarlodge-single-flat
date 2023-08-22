<template>
    <main class="page-content">
        <div class="row">
            <RequestModal :callBackMethod="fetchData" />
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Move Out') }} {{ translate('Request') }}
                            </h5>
                            <div class="ms-auto align-items-right" v-if="user_role == 'Tenant'">
                                <button class="btn btn-secondary m-1" @click="requestModalOpen">
                                    {{ translate('Request') }} {{ translate('Now') }}
                                </button>
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
                                        <th>{{ translate('Tenant') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Flat') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Request') }} {{ translate('Date') }}</th>
                                        <th>{{ translate('Reason') }}</th>
                                        <th>{{ translate('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data" :key="item.id">
                                        <td>{{ item.tenant.name }}</td>
                                        <td>{{ item.flat.name }}</td>
                                        <td>{{ item.move_out_date }}</td>
                                        <td>{{ item.reason }}</td>
                                        <td v-if="user_role == 'Tenant'">{{ statusName(item.status) }}</td>
                                        <td v-else>
                                            <select v-model="item.status" class="form-control " @change="submitForm(item)">
                                                <option value="1">Confirm</option>
                                                <option value="2">Pending</option>
                                                <option value="3">Cancel</option>
                                            </select>
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
import Errors from "@/errors/errors.js";
import { useToast } from "vue-toastification";
import RequestModal from "@/pages/moveOutRequest/requestModal.vue";
import DataTableSearch from "@/components/DataTableSearch.vue"

export default {
    components: { RequestModal, DataTableSearch },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            user_role: localStorage.getItem("role"),
            form: {},
            data: [],
            paginate: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        };
    },

    methods: {
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/move-out-request', {
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
        requestModalOpen() {
            $("#requestModal").modal("show");
        },
        submitForm(item) {
            this.form.status = item.status;
            axios
                .put(`/update-move-out-request-status/${item.id}`, this.form)
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
        }
    },

    mounted() {
        this.fetchData(1, this.perPage);
    },
};
</script>
