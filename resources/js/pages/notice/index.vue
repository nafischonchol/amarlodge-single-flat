<template>
    <main class="page-content">
        <DeleteModal modalId="rowDelete" :onDelete="deleteRow" />
        <vHtmlDetailsModal :data="selectedItem" modalTitle="Details" />
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Notice') }} {{ translate('List') }}
                            </h5>
                            <div class="ms-auto align-items-right">
                                <router-link :to="{ name: 'notice.add' }" class="btn btn-secondary m-1">
                                    {{ translate('Add') }} {{ translate('Notice') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translate('Building') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Title') }}</th>
                                        <th>{{ translate('Details') }}</th>
                                        <th>{{ translate('Status') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item  in  data " :key="item.id">
                                        <td>
                                            <template v-if="item.building">
                                                <span>{{ item.building.name }}</span>
                                            </template>
                                            <template v-else>
                                                <span>All Building</span>
                                            </template>
                                        </td>

                                        <td>
                                            <span>{{ item.title }}</span>
                                        </td>
                                        <td>
                                            <span v-html="getTruncatedContent(item.details)"></span>
                                        </td>
                                        <td>
                                            <span>{{ item.status == 1 ? 'Publish' : 'Disable' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a @click="showDetailsModal(item)" class="text-primary">
                                                    <span class="material-symbols-outlined google-icon visibility"
                                                        role="button">visibility</span>
                                                </a>
                                                <router-link :to="{ name: 'notice.edit', params: { id: item.id } }"
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
import vHtmlDetailsModal from "@/components/vHtmlDetailsModal.vue";



export default {
    components: { DeleteModal, vHtmlDetailsModal },
    data() {
        return {
            toast: useToast(),
            data: {},
            paginate: {},
            rowToDelete: '',
            selectedItem: null,
        };
    },

    methods: {
        showDetailsModal(item) {
            const { id, building, building_id, created_at, status, details, ...filteredItem } = item;
            filteredItem.building = building ? building.name : '';
            filteredItem.status = status === 1 ? 'Publish' : 'Disable';
            filteredItem.details = details;

            this.selectedItem = { ...filteredItem, vHtml: 1 };
            $("#detailsModal").modal("show");
        },

        getTruncatedContent(content) {
            const limit = 10;
            if (content) {
                let truncatedText = String(content); // Convert to string

                // Truncate by words
                const words = truncatedText.split(' ');
                if (words.length > limit) {
                    truncatedText = words.slice(0, limit).join(' ');
                }
                return truncatedText;
            }
            return '';
        },

        fetchData() {
            axios
                .get('/notices')
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
                .delete(`/notices/${this.rowToDelete}`)
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
