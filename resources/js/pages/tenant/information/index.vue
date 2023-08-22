<template>
    <main class="page-content">
        <DeleteModal modalId="rowDelete" :onDelete="deleteRow" />
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Tenant') }} {{ translate('Information')
                            }} {{ translate('List') }} </h5>
                            <div class="ms-auto align-items-right">
                                <router-link :to="{ name: 'tenant.information.add' }" class="btn btn-secondary m-1">
                                    {{ translate('Add') }}
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
                                        <th>{{ translate('Tenant') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Father') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Building') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Flat') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Mobile') }} </th>
                                        <th>{{ translate('NID') }}</th>
                                        <th>{{ translate('Tenant') }}{{ translate('Image') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item  in  data " :key="item.id">
                                        <td>
                                            <span>{{ item.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.father_name }}</span>
                                        </td>
                                        <td>
                                            <span v-if="item.building">{{ item.building.name }}</span>
                                        </td>
                                        <td>
                                            <span v-if="item.flat">{{ item.flat.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.mobile }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.nid }}</span>
                                        </td>
                                        <td>
                                            <img :src="'/' + item.image" alt="Item Image" width="100"
                                                @error="handleImageErrorNoImage($event)" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <router-link
                                                    :to="{ name: 'tenant.information.show', params: { id: item.id } }"
                                                    class="text-primary">
                                                    <span class="material-symbols-outlined google-icon visibility"
                                                        role="button">visibility</span>
                                                </router-link>
                                                <router-link
                                                    :to="{ name: 'tenant.information.edit', params: { id: item.id } }"
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
import DeleteModal from "@/components/deleteModal.vue";
import DataTableSearch from "@/components/DataTableSearch.vue"

export default {
    components: { DeleteModal, DataTableSearch },
    data() {
        return {
            toast: useToast(),
            data: {},
            paginate: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
            rowToDelete: '',
        };
    },
    methods: {
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/tenant-informations', {
                    params: {
                        page,
                        per_page: perPage,
                        search,
                    }
                })
                .then((response) => {
                    this.data = response.data.data;
                    console.log(this.data);
                    this.paginate = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        deleteConfirmation(id) {
            this.rowToDelete = id;
            $("#rowDelete").modal("show");
        },
        deleteRow() {
            if (!this.rowToDelete) return;

            axios
                .delete(`/tenant-informations/${this.rowToDelete}`)
                .then((response) => {
                    this.toast.success(response.data);
                    this.fetchData();
                })
                .catch((error) => {
                    console.error(error);
                })
        }
    },
    mounted() {
        this.fetchData(1, this.perPage);
    },
};
</script>
