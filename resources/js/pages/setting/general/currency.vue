<template>
    <div class="card">
        <div class="card-body">
            <div class="currency-setup">
                <h5 class="text-center my-4">{{ translate('Currency') }} {{ translate('Setup') }}</h5>
                <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('Currency') }} {{ translate('Name') }}</label> <span
                            class="text-danger">*</span>
                        <input name="currency_name" type="text" class="form-control" placeholder="Currency Name"
                            v-model="form.currency_name" />
                        <span v-if="allErrors.has('currency_name')" class="error text-danger text-bold ms-2 mt-2"
                            v-text="allErrors.get('currency_name')"></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('Currency') }} {{ translate('Symbol') }} </label><span
                            class="text-danger">*</span>
                        <input name="currency_symbol" type="text" class="form-control" placeholder="Currency Symbol"
                            v-model="form.currency_symbol" />
                        <span v-if="allErrors.has('currency_symbol')" class="error text-danger text-bold ms-2 mt-2"
                            v-text="allErrors.get('currency_symbol')"></span>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <!-- Add 'text-center' class to center the button -->
                        <button class="btn btn-primary" type="submit">{{ translate('Update') }} </button>
                        <!-- Add 'btn-sm' class for small button -->
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                currency_name: "BDT",
                currency_symbol: "৳"
            },
        };
    },
    methods: { // Corrected from "method" to "methods"
        getCurrency() {
            axios
                .get(`/general-settings/currency`)
                .then((response) => {
                    let data = response.data;
                    if (data && Object.keys(data).length > 0) {
                        this.form = data;
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm() {
            this.loader(true)
            axios
                .put(`/general-settings/currency-update/`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                })
                .finally(() => {
                    this.setCurrencyData();
                });
        },
    },
    created() {
        this.getCurrency();
    }

}
</script>
