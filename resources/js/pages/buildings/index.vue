<template>
    <main class="page-content">
        <DeleteModal modalId="rowDelete" :onDelete="deleteRow" />
        <DetailsModal :data="selectedItem" :image="image" :name="modal_name" modalTitle="Building Details" />
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Building') }} {{ translate('List') }}
                            </h5>
                            <div class="ms-auto align-items-right">
                                <button @click="exportCSV" class="btn btn-info m-1">
                                    {{ translate('Export CSV') }}
                                </button>
                                <router-link :to="{ name: 'building.add' }" class="btn btn-secondary m-1">
                                    {{ translate('Building') }} {{ translate('Add') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th> {{ translate('Building') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Floor') }}</th>
                                        <th>{{ translate('Lift') }}</th>
                                        <th> {{ translate('Booked') }} {{ translate("Flat") }}</th>
                                        <th> {{ translate('Available') }} {{ translate("Flat") }}</th>
                                        <th>{{ translate('Image') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in buildings" :key="item.id">
                                        <td>
                                            <span>{{ item.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.floor }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.lift === 1 ? 'Yes' : 'No' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.booked_flats }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.available_flats }}</span>
                                        </td>
                                        <td>
                                            <img :src="item.image ? '/' + item.image : noImage()" width="100"
                                                @error="handleImageErrorNoImage($event)" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a @click="showDetailsModal(item)" class="text-primary">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">visibility</span>
                                                </a>
                                                <router-link :to="`/building/${item.id}/edit`" class="text-warning">
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
import DetailsModal from "@/components/detailModal.vue";

export default {
    components: { DeleteModal, DetailsModal },
    data() {
        return {
            toast: useToast(),
            buildings: {},
            paginate: {},
            rowToDelete: '',
            selectedItem: null,
            image: null,
            modal_name: null
        };
    },
    methods: {
        exportCSV() {
            downloadCSV('buildings', '/buildings/export-csv');
        },
        showDetailsModal(item) {
            this.image = '/' + item.image;
            this.modal_name = item.name;
            const { id, lift, image, images, ...filteredItem } = item;
            const convertedLift = lift === 1 ? 'Yes' : 'No';
            this.selectedItem = { ...filteredItem, lift: convertedLift };
            $("#detailsModal").modal("show"); // Show the modal using its ID
        },
        fetchData(page = 1) {
            axios
                .get(`/buildings?page=${page}`)
                .then((response) => {
                    this.buildings = response.data.data;
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
                .delete(`/buildings/${this.rowToDelete}`)
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
        this.fetchData();
    },
};
</script>
