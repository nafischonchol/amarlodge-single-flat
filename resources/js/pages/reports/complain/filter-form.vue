<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Complain') }} {{ translate('Report') }}
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
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Building') }}</label>
                                                <select name="building_id" class="form-control" v-model="form.building_id"
                                                    @change="fetchFlat">
                                                    <option selected value="">{{ translate('Choose') }}</option>
                                                    <option v-for="building in buildingList" :key="building.id"
                                                        :value="building.id">
                                                        {{ building.name }}
                                                    </option>
                                                </select>
                                                <span v-if="this.allErrors.has('building_id')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('building_id')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Month') }}</label>
                                                <input name="month" type="month" class="form-control"
                                                    v-model="form.month" />
                                                <span v-if="this.allErrors.has('month')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('month')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">Complain By</label>
                                                <select name="complaint_by" class="form-control"
                                                    v-model="form.complaint_by">
                                                    <option selected value="">{{ translate('Choose') }}</option>
                                                    <option v-for="item in complaint_by_list" :key="item.id"
                                                        :value="item.id">
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                                <span v-if="this.allErrors.has('complaint_by')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('complaint_by')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Complaint Against') }}</label>
                                                <select name="complaint_against" class="form-control"
                                                    v-model="form.complaint_against">
                                                    <option selected value="">{{ translate('Choose') }}</option>
                                                    <option v-for="item in complaint_against_list" :key="item.id"
                                                        :value="item.id">
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                                <span v-if="this.allErrors.has('complaint_against')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('complaint_against')">
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
                            <h5 class="text-center my-1">{{ translate('Complain') }} {{ translate('Report') }}</h5>
                            <div class="table-responsive">
                                <table class="table align-middle table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Date') }}</th>
                                            <th>{{ translate('Building') }}</th>
                                            <th>{{ translate('Title') }}</th>
                                            <th>{{ translate('Complaint By') }}</th>
                                            <th>{{ translate('Complaint Against') }}</th>
                                            <th>{{ translate('Details') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item  in  data " :key="item.id">
                                            <td>
                                                <span>{{ formatDate(item.date) }}</span>
                                            </td>
                                            <td>
                                                <template v-if="item.building">
                                                    <span>{{ item.building.name }}</span>
                                                </template>
                                            </td>
                                            <td>
                                                <span>{{ item.title }}</span>
                                            </td>
                                            <td>
                                                <span v-if="item.complainer">{{ item.complainer.name
                                                }}</span>
                                                <span v-else>{{ item.complaint_by }}</span>
                                            </td>
                                            <td>
                                                <span v-if="item.complain_against_info">{{ item.complain_against_info.name
                                                }}</span>
                                                <span v-else>{{ item.complaint_against }}</span>
                                            </td>
                                            <td>
                                                <span v-html="getTruncatedContent(item.details)"></span>
                                            </td>
                                            <td>
                                                <span>{{ activeStatus(item.status) }}</span>
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


export default {

    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                building_id: "",
                complaint_by: "",
                complaint_against: "",
                month: "",
            },
            data: [],
            buildingList: [],
            complaint_by_list: [],
            complaint_against_list: [],
        };
    },
    methods:
    {
        printReport() {
            const element = document.getElementById('print-div');
            this.print(element)
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
        fetchBuilding() {
            axios
                .get("/buildings/all")
                .then((response) => {
                    this.buildingList = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        complaintAgainstPush() {
            this.complaint_against_list.unshift({ id: "All", name: "All Flat" });
            this.complaint_against_list.unshift({ id: "Owner", name: "Owner" });
        },
        complaintByPush() {
            this.complaint_by_list.unshift({ id: "Owner", name: "Owner" });
        },
        fetchFlat() {
            this.form.complaint_by = "";
            this.form.complaint_against = "";
            axios
                .get(`/flats/building-wise/${this.form.building_id}`)
                .then((response) => {
                    this.complaint_by_list = [...response.data];
                    this.complaint_against_list = [...response.data];
                    this.complaintAgainstPush();
                    this.complaintByPush();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        filterData() {
            this.loader(true)
            axios
                .post("/report/complain", this.form)
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
    },
    mounted() {
        this.fetchBuilding();
        this.complaintAgainstPush();
        this.complaintByPush();
    },

};
</script>

