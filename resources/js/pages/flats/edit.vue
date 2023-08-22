<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Edit') }} {{ translate('Flat') }}</h5>
                            <div class="ms-auto">
                                <router-link to="/flat/list" class="btn btn-secondary m-1">{{ translate('List') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card shadow-none bg-light border">
                                    <div class="card-body">
                                        <form class="row g-3" @keydown="allErrors.clear($event.target.name)"
                                            @submit.prevent="submitForm">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Building') }}</label> <span
                                                    class="text-danger">*</span>
                                                <select name="building_id" type="text" class="form-control"
                                                    v-model="form.building_id" @change="fatchFloors(getSelectedBuilding)">
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
                                                <label class="form-label">{{ translate('Floor') }}</label> <span
                                                    class="text-danger">*</span>
                                                <select name="floor" type="text" class="form-control" v-model="form.floor">
                                                    <option selected value="">{{ translate('Choose') }}</option>
                                                    <option v-for="num in maxFloor" :key="num">
                                                        {{ num }}
                                                    </option>
                                                </select>
                                                <span v-if="this.allErrors.has('floor')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('floor')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Flat') }} {{ translate('Name')
                                                }}</label> <span class="text-danger">*</span>
                                                <input name="name" type="text" class="form-control" v-model="form.name" />
                                                <span v-if="this.allErrors.has('name')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('name')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Available') }} {{
                                                    translate('Utilities') }}</label>
                                                <span class="text-danger">*</span>
                                                <input name="utilities" type="text" class="form-control"
                                                    v-model="form.utilities" />
                                                <span v-if="this.allErrors.has('utilities')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('utilities')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Rent') }}al</label> <span
                                                    class="text-danger">*</span>
                                                <input name="number" type="text" class="form-control"
                                                    v-model="form.rental" />
                                                <span v-if="this.allErrors.has('rental')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('rental')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Area') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="area" type="number" class="form-control" v-model="form.area" />
                                                <span v-if="this.allErrors.has('area')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('area')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Parking Area') }} {{
                                                    translate('Name') }}</label> <span class="text-danger">*</span>
                                                <input name="parking_area" type="text" class="form-control"
                                                    v-model="form.parking_area" />
                                                <span v-if="this.allErrors.has('parking_area')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('parking_area')">
                                                </span>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Room') }}</label><span
                                                    class="text-danger">*</span>
                                                <input name="room" type="number" class="form-control" v-model="form.room" />
                                                <span v-if="this.allErrors.has('room')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('room')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Washroom') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="washroom" type="number" class="form-control"
                                                    v-model="form.washroom" />
                                                <span v-if="this.allErrors.has('washroom')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('washroom')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Balcony') }}
                                                    <span class="small-info">({{ translate('Is balcony exist?') }})</span>
                                                </label>
                                                <select name="balcony" class="form-control" v-model="form.balcony">
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span v-if="this.allErrors.has('balcony')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('balcony')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Bachelors') }}
                                                    <span class="small-info">
                                                        ({{ translate('Is rent available for bachelors?') }})
                                                    </span>
                                                </label>
                                                <select name="rented_to_bachelors" class="form-control"
                                                    v-model="form.rented_to_bachelors">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span v-if="this.allErrors.has('rented_to_bachelors')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('rented_to_bachelors')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Minimum Stay') }} {{
                                                    translate('Month') }}</label>
                                                <input name="minimumStay" type="number" class="form-control"
                                                    v-model="form.minimumStay" />
                                                <span v-if="this.allErrors.has('minimumStay')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('minimumStay')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Youtube') }} {{ translate('Video')
                                                }}
                                                    {{ translate('URL') }}</label>
                                                <input name="youtube_video" type="text" class="form-control"
                                                    v-model="form.youtube_video" />
                                                <span v-if="this.allErrors.has('youtube_video')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('youtube_video')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Notes') }}</label>
                                                <textarea class="form-control" rows="4" cols="4" name="notes"
                                                    v-model="form.notes"></textarea>
                                                <span v-if="this.allErrors.has('notes')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('notes')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Terms & Condition') }}</label>
                                                <textarea class="form-control" rows="4" cols="4" name="termsAndCondition"
                                                    v-model="form.termsAndCondition"></textarea>
                                                <span v-if="this.allErrors.has('termsAndCondition')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('termsAndCondition')">
                                                </span>
                                            </div>
                                            <imagePreviewEdit :form="form" :allErrors="allErrors" :image="image"
                                                :images="images" isRequired="true" />
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
import imagePreviewEdit from "@/components/imagePreviewEdit.vue";

export default {
    components: { imagePreviewEdit },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {},
            image: null,
            images: [],
            flatId: this.$route.params.id,
            buildingList: [],
            maxFloor: 0,
        };
    },
    watch: {
        buildingList: {
            immediate: true,
            handler(buildings) {
                if (buildings.length > 0) {
                    const selectedBuilding = buildings.find(building => building.id === this.form.building_id);
                    this.maxFloor = selectedBuilding ? selectedBuilding.floor : 1;
                }
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
        fetchData() {
            axios
                .get(`/flats/${this.flatId}`)
                .then((response) => {
                    this.form = response.data;
                    this.image = "/" + this.form.image;
                    this.images = JSON.parse(this.form.images);
                    this.form.image = null;
                    this.form.images = null;

                })
                .catch((error) => {
                    console.log("Something goes wrong!");
                });
        },
        fatchFloors(building) {
            this.form.floor = "",
                this.maxFloor = building.floor;
        },

        submitForm() {
            this.loader(true)
            axios
                .put(`/flats/${this.flatId}`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'flat.list' });
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
    computed: {
        getSelectedBuilding() {
            return this.buildingList.find(building => building.id === this.form.building_id) || {};
        }
    },
    mounted() {
        this.fetchData();
        this.fetchBuilding();
    },
};
</script>
