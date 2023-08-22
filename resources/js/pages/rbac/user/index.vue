<template>
    <main class="page-content">
        <div class="row">
            <DeleteModal modalId="rowDelete" :onDelete="deleteRow" />
            <UserAccessModal />
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Users') }} {{ translate('List') }}</h5>
                            <div class="ms-auto align-items-right">
                                <button @click="openAccessRoleModal" class="btn btn-primary m-1">
                                    {{ translate('Set') }} {{ translate('Role') }}
                                </button>
                                <router-link :to="{ name: 'user.add' }" class="btn btn-secondary m-1">
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
                                        <th>{{ translate('SL') }}</th>
                                        <th> {{ translate('Name') }}</th>
                                        <th> {{ translate('Email') }}</th>
                                        <th>{{ translate('Role') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in data" :key="item.id">
                                        <td>
                                            <span>{{ ++index }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.email }}</span>
                                        </td>
                                        <td>
                                            <span v-if="item.roles[0]">
                                                <template v-for="(role, index) in item.roles" :key="index">
                                                    <span v-if="index !== 0">,</span>
                                                    <span>{{ role.name }}</span>
                                                </template>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
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
import UserAccessModal from "./user-access-modal.vue";

export default {
    components: { DeleteModal, UserAccessModal, DataTableSearch },
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
        openAccessRoleModal() {
            $("#user-access-modal").modal("show");
        },
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/rbac/users', {
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
            $("#rowDelete").modal("show");
        },
        deleteRow() {
            if (!this.rowToDelete) return;
            axios
                .delete(`/rbac/users/${this.rowToDelete}`)
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
