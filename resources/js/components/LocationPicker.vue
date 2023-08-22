<template>
    <div :class="colSize">
        <label class="form-label"> {{ translate('Country') }}</label> <span class="text-danger">*</span>
        <select name="country_id" class="form-control" v-model="form.country_id" @change="fetchDivision">
            <option value=""> {{ translate('Choose') }}</option>
            <option v-for="item in countryList" :key="item.id" :value="item.id">
                {{ item.name }}
            </option>
        </select>
        <span v-if="this.allErrors.has('country_id')" class="error text-danger text-bold ms-2 mt-2"
            v-text="this.allErrors.get('country_id')">
        </span>
    </div>
    <div :class="colSize">
        <label class="form-label">{{ translate('Division') }}</label> <span class="text-danger">*</span>
        <select name="division_id" class="form-control" v-model="form.division_id" @change="fetchDistrict">
            <option value=""> {{ translate('Choose') }}</option>
            <option v-for="item in divisionList" :key="item.id" :value="item.id">
                {{ item.name }}
            </option>
        </select>
        <span v-if="this.allErrors.has('division_id')" class="error text-danger text-bold ms-2 mt-2"
            v-text="this.allErrors.get('division_id')">
        </span>
    </div>
    <div :class="colSize">
        <label class="form-label">{{ translate('District') }}</label> <span class="text-danger">*</span>
        <select name="district_id" class="form-control" v-model="form.district_id" @change="fetchUpozila">
            <option value=""> {{ translate('Choose') }}</option>
            <option v-for="item in districtList" :key="item.id" :value="item.id">
                {{ item.name }}
            </option>
        </select>
        <span v-if="this.allErrors.has('district_id')" class="error text-danger text-bold ms-2 mt-2"
            v-text="this.allErrors.get('district_id')">
        </span>
    </div>
    <div :class="colSize">
        <label class="form-label">{{ translate('Upozila') }}</label> <span class="text-danger">*</span>
        <select name="upozila_id" class="form-control" v-model="form.upozila_id">
            <option value=""> {{ translate('Choose') }}</option>
            <option v-for="item in upozilaList" :key="item.id" :value="item.id">
                {{ item.name }}
            </option>
        </select>
        <span v-if="this.allErrors.has('upozila_id')" class="error text-danger text-bold ms-2 mt-2"
            v-text="this.allErrors.get('upozila_id')">
        </span>
    </div>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";

export default {
    props: {
        form: Object, // Pass the "form" object as a prop
        allErrors: Object, // Pass the "form" object as a prop
        colDef: String,
    },
    data() {
        return {
            toast: useToast(),
            countryList: [],
            divisionList: [],
            districtList: [],
            upozilaList: [],
            colSize: "col-lg-6 col-md-6 col-sm-12"
        };
    },
    watch: {
        colDef: {
            immediate: true, // Run the watcher immediately when the component is mounted
            handler(newVal) {
                if (newVal)
                    this.colSize = newVal;
            }
        }
    },
    methods:
    {
        fetchCountry() {
            this.divisionList = [];
            this.districtList = [];
            this.upozilaList = [];
            axios
                .get("/country")
                .then((response) => {
                    this.countryList = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchDivision() {
            this.districtList = [];
            this.upozilaList = [];
            axios
                .get(`/country-wise-division/${this.form.country_id}`)
                .then((response) => {
                    this.divisionList = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchDistrict() {
            this.upozilaList = [];
            axios
                .get(`/division-wise-district/${this.form.division_id}`)
                .then((response) => {
                    this.districtList = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchUpozila() {
            axios
                .get(`/district-wise-upozila/${this.form.district_id}`)
                .then((response) => {
                    this.upozilaList = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    },
    mounted() {
        this.fetchCountry();
    },
};
</script>

