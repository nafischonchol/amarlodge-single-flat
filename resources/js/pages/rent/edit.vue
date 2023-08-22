<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Edit') }} {{ translate('Rent') }}</h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'rent.list' }" class="btn btn-secondary m-1">
                                    {{ translate('List') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12 col-md-12 col-sm-12">
                                <div class="card shadow-none bg-light border">
                                    <div class="card-body">
                                        <form class="row g-3" @keydown="allErrors.clear($event.target.name)"
                                            @submit.prevent="submitForm">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Building') }}</label> <span
                                                    class="text-danger">*</span>
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
                                                <label class="form-label">{{ translate('Booked') }} {{ translate('Flat')
                                                }}</label> <span class="text-danger">*</span>
                                                <select name="flat_id" class="form-control" v-model="form.flat_id">
                                                    <option selected value="">{{ translate('Choose') }}</option>
                                                    <option v-for="item in flatList" :key="item.id" :value="item.id">
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                                <span v-if="this.allErrors.has('flat_id')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('flat_id')">
                                                </span>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Rent') }}</label>
                                                <input name="rent_amount" type="text" class="form-control"
                                                    v-model="form.rent_amount" placeholder="Monthly rent" readonly />
                                                <span v-if="this.allErrors.has('rent_amount')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('rent_amount')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Water') }}
                                                    {{ translate('Bill') }}</label>
                                                <span class="text-danger">*</span>
                                                <input name="water_bill" type="number" class="form-control"
                                                    v-model="form.water_bill" />
                                                <span v-if="this.allErrors.has('water_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('water_bill')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Gas') }} {{ translate('Bill')
                                                }}</label> <span class="text-danger">*</span>
                                                <input name="gas_bill" type="number" class="form-control"
                                                    v-model="form.gas_bill" />
                                                <span v-if="this.allErrors.has('gas_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('gas_bill')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Security') }} {{ translate('Bill')
                                                }}</label>
                                                <input name="security_bill" type="number" class="form-control"
                                                    v-model="form.security_bill" />
                                                <span v-if="this.allErrors.has('security_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('security_bill')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Garbage') }} {{ translate('Bill')
                                                }}</label>
                                                <input name="garbage_bill" type="number" class="form-control"
                                                    v-model="form.garbage_bill" />
                                                <span v-if="this.allErrors.has('garbage_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('garbage_bill')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Service') }}
                                                    {{ translate('Charge') }}</label>
                                                <input name="service_charge" type="number" class="form-control"
                                                    v-model="form.service_charge" min="0" />
                                                <span v-if="this.allErrors.has('service_charge')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('service_charge')">
                                                </span>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Electric') }} {{ translate('Bill')
                                                }}</label>
                                                <input name="electric_bill" type="number" class="form-control"
                                                    v-model="form.electric_bill" />
                                                <span v-if="this.allErrors.has('electric_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('electric_bill')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Other') }} {{ translate('Bill')
                                                }}</label>
                                                <input name="other_bill" type="number" class="form-control"
                                                    v-model="form.other_bill" />
                                                <span v-if="this.allErrors.has('other_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('other_bill')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Total') }}
                                                    {{ translate('Amount') }}</label>
                                                <input type="number" class="form-control" v-model="totalAmount" readonly />
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
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--end row-->
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
            form: {},
            routeId: this.$route.params.id,
            buildingList: [],
            flatList: [],
            totalRent: 0
        };
    },
    computed: {
        totalAmount() {
            const billFields = ['rent_amount', 'water_bill', 'gas_bill', 'security_bill', 'garbage_bill', 'service_charge', 'electric_bill', 'other_bill'];

            return billFields.reduce((total, field) => {
                if (this.form[field]) {
                    total += parseFloat(this.form[field]);
                }
                return total;
            }, 0);
        }
    },
    methods:
    {
        fetchFlat() {
            axios
                .get(`/flats/building-wise/booked/${this.form.building_id}`)
                .then((response) => {
                    this.flatList = response.data;
                    if (this.flatList.length <= 0) {
                        this.form.flat_id = "";
                        this.toast.error("Flat not booked here");
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchBuilding() {
            return new Promise((resolve, reject) => {
                axios
                    .get("/buildings/all")
                    .then((response) => {
                        this.buildingList = response.data;
                        resolve(this.buildingList);
                    })
                    .catch((error) => {
                        console.error(error);
                        reject(error);
                    });
            });
        },


        fetchData() {
            axios
                .get(`/rents/${this.routeId}`)
                .then((response) => {
                    this.form = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm() {
            this.loader(true)
            axios
                .put(`/rents/${this.routeId}`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'rent.list' });
                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        console.log(error.response.data);
                        this.toast.error(error.response.data);
                    }
                });
        },
    },

    async mounted() {
        this.fetchData();
        this.fetchBuilding()
            .then((data) => {
                this.fetchFlat();
            })
            .catch((error) => {
                console.log(error);
            });

    }
};
</script>

