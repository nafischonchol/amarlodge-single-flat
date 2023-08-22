<template>
    <div :class="colSize">
        <label class="form-label">{{ translate('Building') }}</label>
        <select name="building_id" class="form-control" v-model="form.building_id" @change="fetchFlat">
            <option selected value="">{{ translate('Choose') }}</option>
            <option v-for="building in buildingList" :key="building.id" :value="building.id">
                {{ building.name }}
            </option>
        </select>
        <span v-if="this.allErrors.has('building_id')" class="error text-danger text-bold ms-2 mt-2"
            v-text="this.allErrors.get('building_id')">
        </span>
    </div>
    <div :class="colSize">
        <label class="form-label"> {{ translate('Flat') }}</label>
        <select name="flat_id" class="form-control" v-model="form.flat_id">
            <option selected value="">{{ translate('Choose') }}</option>
            <option v-for="item in flatList" :key="item.id" :value="item.id">
                {{ item.name }}
            </option>
        </select>
        <span v-if="this.allErrors.has('flat_id')" class="error text-danger text-bold ms-2 mt-2"
            v-text="this.allErrors.get('flat_id')">
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
            buildingList: [],
            flatList: [],
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
        },
        'form.building_id': {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.fetchFlat();
                }
            }
        },
    },
    methods:
    {
        fetchFlat() {
            axios
                .get(`/flats/building-wise/${this.form.building_id}`)
                .then((response) => {
                    this.flatList = response.data;
                })
                .catch((error) => {
                    console.error(error);
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
    },
    mounted() {
        this.fetchBuilding();
    },
};
</script>

