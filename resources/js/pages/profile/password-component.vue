<template>
    <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <small class="form-label"> {{ translate('Old') }} {{ translate('Password') }}</small> <span
                class="text-danger">*</span>
            <input name="old_password" type="password" class="form-control" v-model="form.old_password" autocomplete="on" />
            <span v-if="this.allErrors.has('old_password')" class="error text-danger text-bold ms-2 mt-2"
                v-text="this.allErrors.get('old_password')">
            </span>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <small class="form-label"> {{ translate('New') }} {{ translate('Password') }}</small> <span
                class="text-danger">*</span>
            <input name="new_password" type="password" class="form-control" v-model="form.new_password" autocomplete="on" />
            <span v-if="this.allErrors.has('new_password')" class="error text-danger text-bold ms-2 mt-2"
                v-text="this.allErrors.get('new_password')">
            </span>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-sm-0 col-md-5 col-lg-5"></div>
                <div class="col-sm-12 col-md-2 col-lg-2">
                    <button class="form-control btn btn-primary" type="submit">
                        {{ translate('Submit') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
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
                old_password: "",
                new_password: ""
            },
        };
    },
    methods:
    {
        submitForm() {
            this.loader(true)
            axios
                .put("/password-update", this.form)
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
                });
        },
    },
};
</script>

