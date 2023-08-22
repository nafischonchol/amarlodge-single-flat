<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Visitor') }} {{ translate('Report') }}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12 col-md-12 col-sm-12">
                                <div class="card shadow-none bg-light border">
                                    <div class="card-body">
                                        <form class="row g-3" @keydown="allErrors.clear($event.target.name)"
                                            @submit.prevent="filterData">
                                            <BuildingFlatPicker :form="form" :allErrors="allErrors" />
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Month') }}</label>
                                                <input name="month" type="month" class="form-control"
                                                    v-model="form.month" />
                                                <span v-if="this.allErrors.has('month')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('month')">
                                                </span>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit">
                                                    {{ translate('Submit') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" v-if="data.length > 0">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-secondary" @click="printReport">
                                <span class="material-symbols-outlined">print</span>
                            </button>
                        </div>
                        <div id="print-div">
                            <h5 class="text-center my-1">{{ translate('Visitor') }} {{ translate('Report') }}</h5>
                            <div class="table-responsive">
                                <table class="table align-middle table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Visitor') }}</th>
                                            <th>{{ translate('Host Information') }}</th>
                                            <th>{{ translate('Building') }}</th>
                                            <th>{{ translate('Flat') }}</th>
                                            <th>{{ translate('In Time') }}</th>
                                            <th>{{ translate('Out Time') }}</th>
                                            <th>{{ translate('Purpose') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in  data " :key="item.id">
                                            <td>
                                                {{ item.name }}
                                            </td>
                                            <td>
                                                {{ item.host_information }}
                                            </td>
                                            <td>
                                                <span v-if="item.building">{{ item.building.name }}</span>
                                            </td>
                                            <td>
                                                <span v-if="item.flat">{{ item.flat.name }}</span>
                                            </td>
                                            <td>
                                                {{ formatDateTime(item.in_time) }}
                                            </td>
                                            <td>{{ formatDateTime(item.out_time) }}</td>
                                            <td>
                                                <span>{{ item.purpose }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "@/axios-config";
import Errors from "@/errors/errors.js";
import { useToast } from "vue-toastification";
import BuildingFlatPicker from "@/components/BuildingFlatPicker.vue";

export default {
    components: { BuildingFlatPicker },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                building_id: "",
                flat_id: "",
                month: null,
            },
            data: []
        };
    },
    methods:
    {
        formateFlat(items) {
            const flatNames = [];
            for (const flatId in items) {
                const name = items[flatId];
                flatNames.push(name);
            }
            return flatNames.join(", ");
        },
        printReport() {
            const element = document.getElementById('print-div');
            this.print(element)
        },
        filterData() {
            this.loader(true)
            axios
                .post("/report/visitor", this.form)
                .then((response) => {
                    this.loader(false)
                    this.data = response.data;
                    if (this.data.length > 0)
                        this.toast.success("Show Report");
                    else
                        this.toast.warning("No data found!");

                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
    }

};
</script>

