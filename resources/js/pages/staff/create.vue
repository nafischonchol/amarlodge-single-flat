<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Add') }} {{
                                translate('New') }} {{ translate('Staff') }}</h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'staff.list' }" class="btn btn-secondary m-1">
                                    {{ translate('Staff') }} {{ translate('List') }}
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
                                                <label class="form-label"> {{ translate('Name') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="name" type="text" class="form-control"
                                                    :placeholder="translate('Name')" v-model="form.name" />
                                                <span v-if="this.allErrors.has('name')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('name')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Mobile') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="mobile" type="number" class="form-control"
                                                    v-model="form.mobile" />
                                                <span v-if="this.allErrors.has('mobile')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('mobile')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Email') }}</label>
                                                <input name="email" type="email" class="form-control"
                                                    v-model="form.email" />
                                                <span v-if="this.allErrors.has('email')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('email')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Salary') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="salary" type="number" class="form-control"
                                                    v-model="form.salary" />
                                                <span v-if="this.allErrors.has('salary')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('salary')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Staff') }} {{
                                                    translate('Type') }}</label> <span class="text-danger">*</span>
                                                <select name="type" class="form-control single-select" v-model="form.type">
                                                    <option value="">Select</option>
                                                    <option value="Caretaker">Caretaker</option>
                                                    <option value="Security Guard">
                                                        Security Guard
                                                    </option>
                                                </select>
                                                <span v-if="this.allErrors.has('type')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('type')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('NID') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="nid" type="number" class="form-control" v-model="form.nid" />
                                                <span v-if="this.allErrors.has('nid')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('nid')">
                                                </span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label class="form-label">{{ translate('Full') }} {{ translate('Address') }}
                                                </label> <span class="text-danger">*</span>
                                                <textarea class="form-control" rows="4" cols="4" name="address"
                                                    v-model="form.address"></textarea>
                                                <span v-if="this.allErrors.has('address')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('address')">
                                                </span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label class="form-label"> {{ translate('Details Info') }}</label>
                                                <textarea class="form-control" :placeholder="translate('Details Info')"
                                                    rows="4" cols="4" name="details_info"
                                                    v-model="form.details_info"></textarea>
                                                <span v-if="this.allErrors.has('details_info')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('details_info')">
                                                </span>
                                            </div>

                                            <imagePreviewSingle :form="form" :allErrors="allErrors"
                                                :title="translate('Nid') + ' ' + translate('Image')" />
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit">
                                                    {{ translate('Submit') }}
                                                </button>
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
import imagePreviewSingle from "@/components/imagePreviewSingle.vue";

export default {
    components: { imagePreviewSingle },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                name: "",
                mobile: "",
                email: "",
                salary: "",
                address: "",
                type: "",
                nid: "",
                image: "",
                details_info: "",
            },
        };
    },
    methods:
    {
        submitForm() {
            this.loader(true)
            axios
                .post("/staffs", this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'staff.list' });
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
