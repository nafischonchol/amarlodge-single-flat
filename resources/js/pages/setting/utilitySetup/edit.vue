
<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Utility Bill') }} {{ translate('Edit')
                            }}</h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'setting.utility.setup.list' }" class="btn btn-secondary m-1">
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
                                                <label class="form-label">{{ translate('Building') }}</label><span
                                                    class="text-danger">*</span>
                                                <select name="building_id" class="form-control" v-model="form.building_id">
                                                    <option selected value="">{{ translate('Choose') }}</option>
                                                    <option v-for="building in buildingList" :key="building.id"
                                                        :value="building.id">
                                                        {{ building.name }}
                                                    </option>
                                                </select>
                                                <span v-if="allErrors.has('building_id')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('building_id')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Water') }} {{ translate('Bill') }}
                                                    {{
                                                        translate('Per Flat')
                                                    }}</label><span class="text-danger">*</span>
                                                <input name="water_bill" class="form-control" v-model="form.water_bill"
                                                    type="number" />
                                                <span v-if="allErrors.has('water_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('water_bill')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">
                                                    {{ translate('Gas') }} {{ translate('Bill') }} {{ translate('Per Flat')
                                                    }}
                                                </label><span class="text-danger">*</span>
                                                <input name="gas_bill" class="form-control" v-model="form.gas_bill"
                                                    type="number" />
                                                <span v-if="allErrors.has('gas_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('gas_bill')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">
                                                    {{ translate('Security') }} {{ translate('Bill') }}
                                                    {{ translate('Per Flat') }}
                                                </label>
                                                <span class="text-danger">*</span>
                                                <input name="security_bill" class="form-control"
                                                    v-model="form.security_bill" type="number" />
                                                <span v-if="allErrors.has('security_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('security_bill')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">
                                                    {{ translate('Garbage') }} {{ translate('Bill') }}
                                                    {{ translate('Per Flat') }}
                                                </label><span class="text-danger">*</span>
                                                <input name="garbage_bill" class="form-control" v-model="form.garbage_bill"
                                                    type="number" />
                                                <span v-if="allErrors.has('garbage_bill')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('garbage_bill')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Service') }} {{ translate('Charge')
                                                }} {{
    translate('Per Flat')
}}</label><span class="text-danger">*</span>
                                                <input name="service_charge" class="form-control"
                                                    v-model="form.service_charge" type="number" />
                                                <span v-if="allErrors.has('service_charge')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('service_charge')"></span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit"
                                                    :disabled="isLoading">{{ translate('Submit') }}</button>
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
            form: {
            },
            routeId: this.$route.params.id,
            buildingList: [],
        };
    },
    methods:
    {
        fetchData() {
            axios
                .get(`/setting/utility-setups/${this.routeId}`)
                .then((response) => {
                    this.form = response.data;
                })
                .catch((error) => {
                    console.log("Something goes wrong!");
                });
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
        submitForm() {
            this.loader(true)
            axios
                .put(`/setting/utility-setups/${this.routeId}`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'setting.utility.setup.list' });
                })
                .catch((error) => {
                    this.loader(false)
                    console.log(error.response.data);
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        console.log(error.response.data);
                        this.toast.error("Something goes wrong!");
                    }
                });
        },
    },

    mounted() {
        this.fetchData();
        this.fetchBuilding();
    },
};
</script>


