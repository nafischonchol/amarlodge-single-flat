<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="general-information">
                            <div class="text-center">
                                <h5 class="my-4">{{ translate('General') }} {{ translate('Information') }}</h5>
                            </div>
                            <form class="row g-3" @keydown="allErrors.clear($event.target.name)"
                                @submit.prevent="submitForm">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">{{ translate('Site') }} {{ translate('Name') }}</label> <span
                                        class="text-danger">*</span>
                                    <input name="name" type="text" class="form-control" v-model="form.name" />
                                    <span v-if="allErrors.has('name')" class="error text-danger text-bold ms-2 mt-2"
                                        v-text="allErrors.get('name')"></span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">{{ translate('Mobile') }} </label><span
                                        class="text-danger">*</span>
                                    <input name="mobile" type="text" class="form-control" :placeholder="translate('Mobile')"
                                        v-model="form.mobile" />
                                    <span v-if="allErrors.has('mobile')" class="error text-danger text-bold ms-2 mt-2"
                                        v-text="allErrors.get('mobile')"></span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">{{ translate('Email') }} </label>
                                    <input name="email" type="email" class="form-control" :placeholder="translate('Email')"
                                        v-model="form.email" />
                                    <span v-if="allErrors.has('email')" class="error text-danger text-bold ms-2 mt-2"
                                        v-text="allErrors.get('email')"></span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label"> {{ translate('Address') }}</label>
                                    <input name="address" type="text" class="form-control"
                                        :placeholder="translate('Address')" v-model="form.address" />
                                    <span v-if="allErrors.has('address')" class="error text-danger text-bold ms-2 mt-2"
                                        v-text="allErrors.get('address')"></span>
                                </div>
                                <imagePreviewSingleEdit :form="form" :allErrors="allErrors" :image="image" title="Logo" />
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                    <button class="btn btn-primary" type="submit"> {{ translate('Update') }} </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <DefaultImage />
                <CurrencyComponent />
            </div>
        </div>
    </main>
</template>


<script>
import axios from "@/axios-config";
import Errors from "@/errors/errors.js";
import { useToast } from "vue-toastification";
import CurrencyComponent from "@/pages/setting/general/currency.vue";
import DefaultImage from "@/pages/setting/general/defaultImage.vue";

import imagePreviewSingleEdit from "@/components/imagePreviewSingleEdit.vue";

export default {
    components: { CurrencyComponent, DefaultImage, imagePreviewSingleEdit },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {},
            image: null,
        };
    },
    methods: {
        companyInfo() {
            axios
                .get(`/company-info`)
                .then((response) => {
                    this.form = response.data;
                    this.image = "/" + this.form.image;
                    this.form.image = null;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm() {
            this.loader(true)
            axios
                .put(`/company-info`, this.form)
                .then((response) => {
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    this.loader(false)
                    console.log(error.response.data);
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        console.log(error.response.data);
                        this.toast.error(error.response.data);
                    }
                })
                .finally(() => {
                    this.loader(false)
                    this.setCompanyData();
                });;
        },
    },
    created() {
        this.companyInfo();
    }
}
</script>

