<template>
    <div :class="colSize">
        <label class="form-label"> {{ translate('Building') }}</label>
        <select name="building_id" class="form-control" v-model="form.building_id">
            <option selected value="">{{ translate('Choose') }}</option>
            <option v-for="building in buildingList" :key="building.id" :value="building.id">
                {{ building.name }}
            </option>
        </select>
        <span v-if="this.allErrors.has('building_id')" class="error text-danger text-bold ms-2 mt-2"
            v-text="this.allErrors.get('building_id')">
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

