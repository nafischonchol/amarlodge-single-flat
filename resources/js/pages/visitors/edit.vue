<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Visitor') }} {{
                                translate('Edit') }} </h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'visitor.list' }" class="btn btn-secondary m-1">
                                    {{ translate('Visitor') }} {{ translate('List') }}
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
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate('Host Information') }}</label><span
                                                    class="text-danger">*</span>
                                                <input name="host_information" type="text" class="form-control"
                                                    v-model="form.host_information" />
                                                <span v-if="this.allErrors.has('host_information')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('host_information')">
                                                </span>
                                            </div>
                                            <BuildingFlatPickerEdit :form="form" :allErrors="allErrors"
                                                colDef="col-lg-4 col-md-4 col-sm-12" />
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate('Visitor') }} {{ translate('Name')
                                                }}</label><span class="text-danger">*</span>
                                                <input name="name" type="text" class="form-control" v-model="form.name" />
                                                <span v-if="this.allErrors.has('name')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('name')">
                                                </span>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate('Mobile') }} </label><span
                                                    class="text-danger">*</span>
                                                <input name="mobile" type="text" class="form-control"
                                                    :placeholder="translate('Mobile')" v-model="form.mobile" />
                                                <span v-if="this.allErrors.has('mobile')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('mobile')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate('Purpose') }}</label><span
                                                    class="text-danger">*</span>
                                                <input name="purpose" type="text" class="form-control"
                                                    v-model="form.purpose" />
                                                <span v-if="this.allErrors.has('purpose')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('purpose')">
                                                </span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate('In Time') }}</label>
                                                <input name="in_time" type="datetime-local" class="form-control"
                                                    v-model="form.in_time" />
                                                <span v-if="this.allErrors.has('in_time')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('in_time')">
                                                </span>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate('Out Time') }}</label>
                                                <input name="out_time" type="datetime-local" class="form-control"
                                                    v-model="form.out_time" />
                                                <span v-if="this.allErrors.has('out_time')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('out_time')">
                                                </span>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate('Additional Notes') }}</label>
                                                <textarea class="form-control" rows="4" cols="4" name="additional_notes"
                                                    v-model="form.additional_notes"></textarea>
                                                <span v-if="this.allErrors.has('additional_notes')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('additional_notes')">
                                                </span>
                                            </div>

                                            <imagePreviewSingleEdit :form="form" :allErrors="allErrors" :image="image" />
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
import imagePreviewSingleEdit from "@/components/imagePreviewSingleEdit.vue";
import moment from 'moment';
import BuildingFlatPickerEdit from "@/components/BuildingFlatPickerEdit.vue";

export default {
    components: { imagePreviewSingleEdit, BuildingFlatPickerEdit },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
            },
            routeId: this.$route.params.id,
            buildingList: [],
            flatList: [],
        };
    },
    methods:
    {
        fetchData() {
            axios
                .get(`/visitors/${this.routeId}`)
                .then((response) => {
                    this.form = response.data;
                    this.image = "/" + this.form.image;
                    this.form.image = null;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        formatInOut() {
            if (this.form.in_time)
                this.form.in_time = moment(this.form.in_time).format('YYYY-MM-DD HH:mm:ss');
            if (this.form.out_time)
                this.form.out_time = moment(this.form.out_time).format('YYYY-MM-DD HH:mm:ss');
        },
        submitForm() {
            this.loader(true)
            this.formatInOut();
            axios
                .put(`/visitors/${this.routeId}`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'visitor.list' });
                })
                .catch((error) => {
                    this.loader(false)
                    console.log(error.response.data);
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
    },
    created() {
        this.fetchData();
    }

};
</script>
