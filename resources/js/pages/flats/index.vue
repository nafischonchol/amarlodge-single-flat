<template>
    <main class="page-content">
        <div class="row">
            <DeleteModal modalId="rowDelete" :onDelete="deleteRow" />
            <DetailsModal :data="selectedItem" :image="image" :name="modal_name" modalTitle="Details" />
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Flat') }} {{ translate('List') }}</h5>
                            <div class="ms-auto align-items-right">
                                <button @click="exportCSV" class="btn btn-info m-1">
                                    {{ translate('Export CSV') }}
                                </button>
                                <router-link to="/flat/add" class="btn btn-secondary m-1">
                                    {{ translate('Add') }} {{ translate('Flat') }}
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
                                        <th>{{ translate('Building') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Floor') }}</th>
                                        <th>{{ translate('Flat') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Rent') }}</th>
                                        <th>{{ translate('Booked') }}</th>
                                        <th>{{ translate('Image') }}</th>
                                        <th>{{ translate('Tenant') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data" :key="item.id">
                                        <td>
                                            <span v-if="item.building">{{ item.building.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.floor }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ currency_symbol + " " + item.rental }}</span>
                                        </td>
                                        <td>
                                            <span>{{ yesNo(item.booked) }}</span>
                                        </td>
                                        <td>
                                            <img :src="item.image ? '/' + item.image : noImage()" width="100"
                                                @error="handleImageErrorNoImage($event)" />
                                        </td>
                                        <td>
                                            <template v-if="item.tenant">
                                                {{ item.tenant.name }}
                                            </template>
                                            <template v-else>
                                                <router-link class="btn btn-primary"
                                                    :to="{ name: 'tenant.add.from.flat', params: { flat_id: item.id } }">
                                                    {{ translate('Add') }} {{ translate('Tenant') }}
                                                </router-link>
                                            </template>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a @click="showDetailsModal(item)" class="text-primary">
                                                    <span class="material-symbols-outlined google-icon visibility"
                                                        role="button">visibility</span>

                                                </a>
                                                <router-link :to="{ name: 'flat.edit', params: { id: item.id } }"
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
import DetailsModal from "@/components/detailModal.vue";
import { downloadCSV } from "@/utils/exportData.js";
import DataTableSearch from "@/components/DataTableSearch.vue";

export default {
    components: { DeleteModal, DetailsModal, DataTableSearch },
    data() {
        return {
            toast: useToast(),
            data: [],
            paginate: {},
            perPage: 10,
            items: [10, 20, 30, 40, 50],
            selectedItem: null,
            image: null,
            modal_name: null,
            rowToDelete: null
        };
    },
    methods: {
        exportCSV() {
            downloadCSV("flats", "/flats/export-csv");
        },
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/flats', {
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
        showDetailsModal(item) {
            const { id, image, images, name, building, building_id, tenant, booked, rented_to_bachelors, minimumStay, termsAndCondition, rental, ...filteredItem } = item;

            this.image = '/' + image;
            this.modal_name = name;

            filteredItem.building = building ? building.name : '';
            filteredItem.tenant = tenant ? tenant.name : '';
            filteredItem.rental = this.currency_symbol + " " + rental;
            filteredItem.booked = this.yesNo(booked);
            filteredItem.rented_to_bachelors = this.yesNo(rented_to_bachelors);
            filteredItem.minimum_stay = minimumStay + " Month";

            this.selectedItem = { building, tenant, rental, ...filteredItem }
            $("#detailsModal").modal("show");
        },
        deleteConfirmation(id) {
            this.rowToDelete = id;
            $("#rowDelete").modal("show");
        },
        deleteRow() {
            if (!this.rowToDelete) return;

            axios
                .delete(`/flats/${this.rowToDelete}`)
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
        this.fetchData(1, this.perPage);
    },
};
</script>
