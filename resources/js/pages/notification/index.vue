<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Notifications') }} {{ translate('List')
                            }} </h5>
                        </div>
                        <hr />
                        <DataTableSearch :perPage="perPage" :items="items" :fetchData="fetchData" />
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translate('Meeting') }} {{ translate('Date') }}</th>
                                        <th>{{ translate('Title') }}</th>
                                        <th>{{ translate('Details Info') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in   data  " :key="item.id">
                                        <td>
                                            <span>{{ formatDate(item.date) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.title }}</span>
                                        </td>
                                        <td>
                                            <span v-html="getTruncatedContent(item.description)"></span>
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
            data: [],
            paginate: {},
            search: '',
            perPage: 10,
            items: [5, 10, 20, 30, 40, 50],
        };
    },

    methods: {
        getTruncatedContent(content) {
            const limit = 10;
            if (content) {
                let truncatedText = String(content); // Convert to string

                const words = truncatedText.split(' ');
                if (words.length > limit) {
                    truncatedText = words.slice(0, limit).join(' ');
                }
                return truncatedText;
            }
            return '';
        },
        fetchData(page = 1, perPage = this.perPage, search = this.search) {
            axios
                .get('/notifications', {
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
        markAsRead() {
            axios
                .post('/notifications/mark-as-read')
                .catch((error) => {
                    console.error(error);
                });
        }
    },
    mounted() {
        this.fetchData(1, this.perPage);
        this.markAsRead();
    },
};
</script>
