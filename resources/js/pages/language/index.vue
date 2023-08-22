<template>
    <main class="page-content">
        <CreateModal :onFatch="fetchData" />
        <EditModal :data="this.selectedItem" :onFatch="fetchData" />
        <DeleteModal modalId="rowDelete" :onDelete="deleteCode" />
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Language') }}</h5>
                            <div class="ms-auto align-items-right">
                                <button class="btn btn-secondary m-1" @click="showCreateModal()">
                                    {{ translate('Add') }} {{ translate('Language') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translate('SL') }}</th>
                                        <th> {{ translate('Name') }}</th>
                                        <th>{{ translate('Code') }}</th>
                                        <th>{{ translate('Status') }}</th>
                                        <th>{{ translate('Default') }}</th>
                                        <th class="text-center">{{ translate('Translate') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index)  in  data " :key="index">
                                        <td>
                                            <span>{{ ++index }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ this.convertToUpperCase(item.code) }}</span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    :checked="item.status" @change=updateStatus(item.code)>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    :checked="item.default" @change=updateDefaultStatus(item.code)>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <router-link class="text-warning" v-if="item.code != 'en'"
                                                :to="{ name: 'language.translate', params: { code: item.code } }">
                                                <span class="material-symbols-outlined google-icon"
                                                    role="button">edit_square</span>
                                            </router-link>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6" v-if="item.code != 'en'">
                                                <a class="text-warning" @click="showEditModal(item)">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">edit_square</span>
                                                </a>
                                                <a @click="deleteConfirmation(item.code)" class="text-danger">
                                                    <span class="material-symbols-outlined google-icon"
                                                        role="button">delete</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
import CreateModal from "@/pages/language/create-modal.vue";
import EditModal from "@/pages/language/edit-modal.vue";
import DeleteModal from "@/components/deleteModal.vue";
import { languageStore } from "@/stores/language.js";
export default {
    components: { CreateModal, EditModal, DeleteModal },
    data() {
        return {
            toast: useToast(),
            language: languageStore(),
            data: {},
            selectedItem: {},
            codeToDelete: '',
        };
    },

    methods: {

        updateDefaultStatus(code) {
            let form = { code: code }
            axios
                .put(`/language/update-default-status`, form)
                .then((response) => {
                    this.language.setDefault(code);
                    this.fetchData();
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
        updateStatus(code) {
            let form = { code: code }
            axios
                .put(`/language/update-status`, form)
                .then((response) => {
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
        fetchData() {
            axios
                .get(`/language`)
                .then((response) => {
                    this.data = response.data;
                    if (this.data) {
                        this.data = this.data.slice().reverse()
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        showCreateModal() {
            $("#createModal").modal("show");
        },
        showEditModal(item) {
            this.selectedItem = item;
            $("#editModal").modal("show");
        },
        deleteConfirmation(code) {
            this.codeToDelete = code;
            $("#rowDelete").modal("show");
        },
        deleteCode() {
            if (!this.codeToDelete) return;
            axios
                .delete(`/language/${this.codeToDelete}`)
                .then((response) => {
                    this.toast.success(response.data);
                    this.fetchData();
                })
                .catch((error) => {
                    console.error(error);
                })
        }
    },
    created() {
        this.fetchData();
    }

};
</script>
