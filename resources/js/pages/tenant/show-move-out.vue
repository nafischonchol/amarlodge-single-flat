<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Move Out') }} {{ translate('List') }}
                            </h5>
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
                                        <th>{{ translate('Flat') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Mobile') }} </th>
                                        <th>{{ translate('Rent Month') }}</th>
                                        <th>{{ translate('Move Out') }} {{ translate('Date') }}</th>
                                        <th>{{ translate('Tenant') }} {{ translate('Image') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item  in  data " :key="item.id">
                                        <td>
                                            <span>{{ item.tenant.name }}</span>
                                        </td>

                                        <td>
                                            <span v-if="item.flat">{{ item.flat.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.tenant.mobile }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.rent_month }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.move_out_date }}</span>
                                        </td>
                                        <td>
                                            <img :src="'/' + item.tenant.image" alt="Item Image" width="100"
                                                @error="handleImageErrorNoImage($event)" />
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
import DataTableSearch from "@/components/DataTableSearch.vue"

export default {
    components: { DataTableSearch },
    data() {
        return {
            toast: useToast(),
            data: {},
            paginate: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        };
    },

    methods: {
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/move-out-list', {
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
