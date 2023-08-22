<template>
    <main class="page-content">
        <div class="row">
            <DeleteModal modalId="staffDelete" :onDelete="deleteStaff" />
            <DetailsModal :data="selectedStaff" :modalTitle="translate('Staff') + '  ' + translate('Details')" />
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Staff') }} {{ translate('List') }}</h5>
                            <div class="ms-auto align-items-right">
                                <button @click="exportCSV" class="btn btn-info m-1">
                                    {{ translate('Export CSV') }}
                                </button>
                                <router-link :to="{ name: 'staff.add' }" class="btn btn-secondary m-1">
                                    {{ translate('Add') }} {{ translate('Staff') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <!-- <th>Serial</th> -->
                                        <th> {{ translate('Name') }}</th>
                                        <th> {{ translate('Mobile') }}</th>
                                        <th> {{ translate('Type') }}</th>
                                        <th> {{ translate('Salary') }}</th>
                                        <th> {{ translate('NID') }}</th>
                                        <th> {{ translate('Address') }}</th>
                                        <th> {{ translate('Nid') }} {{ translate('Image') }}</th>
                                        <th> {{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="  item   in    data   " :key="item.id">

                                        <td>
                                            <span>{{ item.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.mobile }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.type }}</span>
                                        </td>
                                        <td>
                                            <span>{{ currency_symbol + " " + item.salary }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.nid }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.address }}</span>
                                        </td>
                                        <td>
                                            <img :src="item.nid_image ? '/' + item.nid_image : noImage()" height=" 100"
                                                width="100" @error="handleImageErrorNoImage($event)" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a @click="showStaffModal(item)" class="text-primary">
                                                    <span class="material-symbols-outlined google-icon visibility"
                                                        role="button">visibility</span>

                                                </a>
                                                <router-link :to="{ name: 'staff.edit', params: { id: item.id } }"
                                                    class="text-warning">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">edit_square</span>
                                                </router-link>
                                                <a @click="deleteStaffConfirmation(item.id)" class="text-danger">
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
import DetailsModal from "@/components/detailModal.vue";
import { downloadCSV } from "@/utils/exportData.js";

export default {
    components: { Breadcrumb, DeleteModal, DetailsModal },
    data() {
        return {
            toast: useToast(),
            data: [],
            paginate: {},
            selectedStaff: null, // Store the selected staff object
            staffToDelete: null, // Store the staff ID to delete

        };
    },
    methods: {
        exportCSV() {
            downloadCSV("staffs", "/staffs/export-csv");
        },
        fetchData(page = 1) {
            axios
                .get(`/staffs?page=${page}`)
                .then((response) => {
                    this.data = response.data.data;
                    this.paginate = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        showStaffModal(staff) {
            const { id, nid_image, ...filteredStaff } = staff; // Exclude the 'id' field
            this.selectedStaff = filteredStaff;
            console.log(this.selectedStaff)
            $("#detailsModal").modal("show"); // Show the modal using its ID
        },
        deleteStaffConfirmation(staffId) {
            this.staffToDelete = staffId;
            $("#staffDelete").modal("show");
        },
        deleteStaff() {
            if (!this.staffToDelete) return;
            axios
                .delete(`/staffs/${this.staffToDelete}`)
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
        this.fetchData();
    },
};
</script>
