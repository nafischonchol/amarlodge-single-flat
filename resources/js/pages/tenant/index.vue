<template>
    <main class="page-content">
        <DeleteModal modalId="rowDelete" :onDelete="deleteRow" />
        <MoveOutModal :tenant_id="tenantToMove" :fetchData="fetchData" />
        <DetailsModal :data="selectedItem" :image="image" :name="modal_name" modalTitle="Details" />
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Tenant') }} {{ translate('List') }}
                            </h5>
                            <div class="ms-auto align-items-right">
                                <button @click="exportCSV" class="btn btn-primary m-1">
                                    {{ translate('Export CSV') }}
                                </button>
                                <router-link :to="{ name: 'tenant.add' }" class="btn btn-secondary m-1">
                                    {{ translate('Add') }} {{ translate('Tenant') }}
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
                                        <th>{{ translate('Building') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Flat') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Mobile') }} </th>
                                        <th>{{ translate('Tenant') }} {{ translate('Image') }}</th>
                                        <th>{{ translate('Rent Per Month') }}</th>
                                        <th>{{ translate('Status') }}</th>
                                        <th>{{ translate('Moved') }} </th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item  in  data " :key="item.id">
                                        <td>
                                            <span>{{ item.name }}</span>
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
                                            <img :src="item.image ? '/' + item.image : noImage()" width="100"
                                                @error="handleImageErrorNoImage($event)" />
                                        </td>
                                        <td>
                                            <span>{{ currency_symbol + " " + item.rent_per_month }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.status == 1 ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning" @click="moveOutModal(item.id)"
                                                v-if="item.flat">{{
                                                    translate('Move Out') }}</button>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a @click="showDetailsModal(item)" class="text-primary">
                                                    <span class="material-symbols-outlined google-icon visibility"
                                                        role="button">visibility</span>
                                                </a>
                                                <router-link :to="{ name: 'tenant.edit', params: { id: item.id } }"
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
import { downloadCSV } from '@/utils/exportData.js';
import DeleteModal from "@/components/deleteModal.vue";
import MoveOutModal from "@/pages/tenant/movedConfirmModel.vue";
import DataTableSearch from "@/components/DataTableSearch.vue"
import DetailsModal from "@/components/detailModal.vue";

export default {
    components: { DeleteModal, MoveOutModal, DataTableSearch, DetailsModal },
    data() {
        return {
            toast: useToast(),
            data: {},
            paginate: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
            rowToDelete: '',
            tenantToMove: 0,
            selectedItem: null,
            image: null,
            modal_name: null,
        };
    },

    methods: {
        showDetailsModal(item) {
            const { id, image, building, building_id, flat, flat_id, name, ...filteredItem } = item;
            this.image = '/' + image;
            this.modal_name = name;
            filteredItem.building = building ? building.name : '';
            filteredItem.flat = flat ? flat.name : '';
            filteredItem.rent_per_month = this.currency_symbol + " " + item.rent_per_month;
            filteredItem.advanced_amount = this.currency_symbol + " " + item.advanced_amount;
            filteredItem.status = item.status == 1 ? 'Active' : 'Inactive'
            filteredItem.issue_date = this.formatDate(item.issue_date);
            filteredItem.rent_month = this.formatMonth(item.rent_month);

            this.selectedItem = { building, flat, ...filteredItem }
            $("#detailsModal").modal("show");
        },
        moveOutModal(tenant_id) {
            this.tenantToMove = tenant_id;
            $("#move-out-modal").modal("show");
        },
        exportCSV() {
            downloadCSV('tenant', '/tenants/export-csv');
        },
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/tenants', {
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
                .delete(`/tenants/${this.rowToDelete}`)
                .then((response) => {
                    this.toast.success(response.data);
                    this.fetchData();
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {

                });
        }
    },
    mounted() {
        this.fetchData(1, this.perPage);
    },
};
</script>
