<template>
    <main class="page-content">
        <div class="row">

            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Activity Log') }}</h5>
                        </div>
                        <hr />
                        <DataTableSearch :perPage="perPage" :items="items" :fetchData="fetchData" />
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translate('User') }}</th>
                                        <th>{{ translate('Date') }}</th>
                                        <th>{{ translate('Activity') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in   data  " :key="item.id">
                                        <td>
                                            <span v-if="item.user">{{ item.user.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ formatDateTime(item.created_at) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.activity }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{ translate('Showing') }} {{ paginate.from }} {{ translate('to') }} {{ paginate.to }} {{
                                    translate('of') }} {{ paginate.total }}
                                {{ translate('entries') }}
                            </div>
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
import DataTableSearch from "@/components/DataTableSearch.vue";

export default {
    components: { DataTableSearch },
    data() {
        return {
            toast: useToast(),
            data: [],
            paginate: {},
            selectedItem: null,
            perPage: 100,
            items: [50, 100, 200, 300, 400, 500],
        };
    },
    methods: {
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/activity-log', {
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
    },
    mounted() {
        this.fetchData(1, this.perPage);
    },
};
</script>
