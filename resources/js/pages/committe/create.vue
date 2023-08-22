<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Add') }} {{ translate('New') }} {{
                                translate('Member') }}
                            </h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'committe.list' }" class="btn btn-secondary m-1">
                                    {{ translate('List') }}
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
                                            <BuildingPicker :form="form" :allErrors="allErrors" />
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Name') }} </label><span
                                                    class="text-danger">*</span>
                                                <input name="name" type="text" class="form-control" v-model="form.name" />
                                                <span v-if="this.allErrors.has('name')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('name')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Mobile') }} </label> <span
                                                    class="text-danger">*</span>
                                                <input name="mobile" type="number" class="form-control"
                                                    v-model="form.mobile" />
                                                <span v-if="this.allErrors.has('mobile')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('mobile')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Email') }} </label> <span
                                                    class="text-danger">*</span>
                                                <input name="email" type="email" class="form-control"
                                                    v-model="form.email" />
                                                <span v-if="this.allErrors.has('email')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('email')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('NID') }}</label> <span
                                                    class="text-danger" v-if="isRequired">*</span>
                                                <input name="nid" type="number" class="form-control" v-model="form.nid" />
                                                <span v-if="this.allErrors.has('nid')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('nid')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Present') }} {{
                                                    translate('Address') }}</label> <span class="text-danger">*</span>
                                                <input name="present_address" type="text" class="form-control"
                                                    v-model="form.present_address" />
                                                <span v-if="this.allErrors.has('present_address')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('present_address')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Permanent') }} {{
                                                    translate('Address') }}</label>
                                                <input name="permanet_address" type="text" class="form-control"
                                                    v-model="form.permanet_address" />
                                                <span v-if="this.allErrors.has('permanet_address')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('permanet_address')">
                                                </span>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Designation') }}</label>
                                                <select name="designation" class="form-control single-select"
                                                    v-model="form.designation">
                                                    <option value="">{{ translate('Choose') }}</option>
                                                    <option value="Moderator">Moderator</option>
                                                    <option value="Secretary General">Secretary General</option>
                                                    <option value="Member">Member</option>
                                                </select>
                                                <span v-if="this.allErrors.has('designation')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('designation')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Status') }} </label>
                                                <select name="status" class="form-control" v-model="form.status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                <span v-if="this.allErrors.has('status')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('status')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Joining') }} {{ translate('Date')
                                                }}
                                                </label> <span class="text-danger">*</span>
                                                <input name="joining_date" type="date" class="form-control"
                                                    v-model="form.joining_date" />
                                                <span v-if="this.allErrors.has('joining_date')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('joining_date')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('End') }} {{ translate('Date') }}
                                                </label>
                                                <input name="end_date" type="date" class="form-control"
                                                    v-model="form.end_date" />
                                                <span v-if="this.allErrors.has('end_date')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('end_date')">
                                                </span>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label class="form-label">{{ translate('Details Info') }} </label>
                                                <textarea class="form-control" rows="4" cols="4" name="details_info"
                                                    v-model="form.details_info"></textarea>
                                                <span v-if="this.allErrors.has('details_info')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('details_info')">
                                                </span>
                                            </div>
                                            <imagePreviewSingle :form="form" :allErrors="allErrors"
                                                :title="translate('Image')" />
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit"
                                                    :disabled="isLoading">{{
                                                        translate('Submit') }} </button>
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
import BuildingPicker from "@/components/BuildingPicker.vue";
import imagePreviewSingle from "@/components/imagePreviewSingle.vue";

export default {
    components: { BuildingPicker, imagePreviewSingle },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                building_id: "",
                name: "",
                mobile: "",
                email: "",
                present_address: "",
                permanet_address: "",
                nid: "",
                designation: "",
                status: 1,
                joining_date: "",
                end_date: "",
                details_info: "",
                image: "",
            },
        };
    },
    methods:
    {
        submitForm() {
            this.loader(true)
            axios
                .post("/management-committe", this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'committe.list' });
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
