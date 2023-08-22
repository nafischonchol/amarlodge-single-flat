<template>
    <main class="page-content">
        <div class="row">
            <DeleteModal modalId="deleteModal" :onDelete="delete" />
            <DetailsModal :data="selectedItem" :image="image" :name="modal_name" modalTitle="Details" />
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Member') }} {{ translate('List') }}
                            </h5>
                            <div class="ms-auto align-items-right">
                                <router-link :to="{ name: 'committe.add' }" class="btn btn-secondary m-1">
                                    {{ translate('Add') }} {{ translate('Member') }}
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
                                        <th>{{ translate('Building') }}</th>
                                        <th> {{ translate('Name') }}</th>
                                        <th>{{ translate('Mobile') }} </th>
                                        <th>{{ translate('NID') }}</th>
                                        <th>{{ translate('Designation') }}</th>
                                        <th>{{ translate('Present Address') }}</th>
                                        <th>{{ translate('Image') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in  data " :key="item.id">
                                        <td>
                                            <span v-if="item.building">{{ item.building.name }}</span>
                                            <span v-else>All</span>
                                        </td>
                                        <td>
                                            <span>{{ item.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.mobile }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.nid }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.designation }}</span>
                                        </td>

                                        <td>
                                            <span>{{ item.present_address }}</span>
                                        </td>
                                        <td>
                                            <img :src="item.image ? '/' + item.image : noImage()" height=" 100" width="100"
                                                @error="handleImageErrorNoImage($event)" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a @click="showDetailsModal(item)" class="text-primary">
                                                    <span class="material-symbols-outlined google-icon visibility"
                                                        role="button">visibility</span>
                                                </a>
                                                <router-link :to="{ name: 'committe.edit', params: { id: item.id } }"
                                                    class="text-warning">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">edit_square</span>
                                                </router-link>
                                                <a @click="deleteConfirmation(item.id)" class="text-danger">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">delete</span></a>
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
import DataTableSearch from "@/components/DataTableSearch.vue";
import DetailsModal from "@/components/detailModal.vue";

export default {
    components: { DeleteModal, DataTableSearch, DetailsModal },
    data() {
        return {
            toast: useToast(),
            data: [],
            paginate: {},
            search: '',
            perPage: 20,
            items: [20, 30, 40, 50, 100],
            rowToDelete: null,
            selectedItem: null,
            image: null,
            modal_name: null,
        };
    },
    methods: {
        showDetailsModal(item) {
            const { id, image, building, building_id, status, joining_date, end_date, ...filteredItem } = item;
            this.image = '/' + image;
            this.modal_name = item.name;
            filteredItem.building = building ? building.name : '';
            filteredItem.joining_date = this.formatDate(joining_date);
            filteredItem.end_date = this.formatDate(end_date);
            this.selectedItem = { building, ...filteredItem }
            $("#detailsModal").modal("show");
        },
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/management-committe', {
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
        deleteConfirmation(id) {
            this.rowToDelete = id;
            $("#deleteModal").modal("show");
        },
        delete() {
            if (!this.rowToDelete) return;
            axios
                .delete(`/management-committe/${this.rowToDelete}`)
                .then((response) => {
                    this.toast.success(response.data);
                    this.fetchData();
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    $("#deleteModal").modal("hide");
                });
        },
    },
    mounted() {
        this.fetchData(1, this.perPage);
    },
};
</script>
