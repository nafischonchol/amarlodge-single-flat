<template>
    <main class="page-content">
        <DeleteModal modalId="rowDelete" :onDelete="deleteRow" />
        <CreateModal @afterSubmit="fetchData" />
        <EditModal :bankData="selected" @afterSubmit="fetchData" />
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Bank') }} {{ translate('Setup') }}</h5>
                            <div class="ms-auto align-items-right">
                                <button class="btn btn-secondary m-1" @click="showCreateModal">
                                    {{ translate('Add') }} {{ translate('New') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translate('SL') }} </th>
                                        <th>{{ translate('Bank') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Bank') }} {{ translate('Type') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index)  in  data " :key="item.id">
                                        <td>
                                            <span>{{ ++index }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.bank_name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ translate(item.bank_type) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a @click="showEditModal(item)" class="text-warning cursor-pointer">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">edit_square</span>

                                                </a>
                                                <a @click="deleteConfirmation(item.id)" class="text-danger cursor-pointer">
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
import CreateModal from "@/pages/setting/bankSetup/Create.vue";
import EditModal from "@/pages/setting/bankSetup/Edit.vue";


export default {
    components: { DeleteModal, CreateModal, EditModal },
    data() {
        return {
            toast: useToast(),
            data: {},
            paginate: {},
            rowToDelete: '',
            selected: null
        };
    },

    methods: {
        showCreateModal() {
            $("#modal").modal("show");
        },
        showEditModal(item) {
            this.selected = item;
            $("#edit-modal").modal("show");
        },
        fetchData(page = 1) {
            axios
                .get(`/setting/bank-setup?page=${page}`)
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
            $("#rowDelete").modal("show");
        },
        deleteRow() {
            if (!this.rowToDelete) return;

            axios
                .delete(`/setting/bank-setup/${this.rowToDelete}`)
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
        this.fetchData();
    }
};
</script>
