<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Upcoming Available') }} {{
                                translate('Flat') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translate('Building') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Floor') }}</th>
                                        <th>{{ translate('Flat') }} {{ translate('Name') }}</th>
                                        <th>{{ translate('Rent') }}</th>
                                        <th>{{ translate('Available On') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data" :key="item.id">
                                        <td>
                                            <span v-if="item.building">{{ item.building.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.floor }}</span>
                                        </td>
                                        <td>
                                            <span>{{ item.name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ currency_symbol + " " + item.rental }}</span>
                                        </td>
                                        <td>
                                            <span>{{ formatDate(item.next_available_date) }}</span>
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


export default {
    data() {
        return {
            toast: useToast(),
            data: [],
        };
    },
    methods: {

        fetchData() {
            axios
                .get('/flats/upcoming-availability')
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        yesNo(item) {
            return item == 1 ? 'Yes' : 'No';
        }
    },

    mounted() {
        this.fetchData();
    },
};
</script>
