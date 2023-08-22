<template>
    <div class="card">
        <div class="card-body">
            <div class="currency-setup">
                <h5 class="text-center my-4">{{ translate('Default Image') }} </h5>
                <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">
                    <imagePreviewSingleEdit :form="form" :allErrors="allErrors" :image="image" title="Default Image"
                        isRequired="true" />
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <button class="btn btn-primary" type="submit">{{ translate('Set') }} {{ translate('Default Image')
                        }}</button>
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
import imagePreviewSingleEdit from "@/components/imagePreviewSingleEdit.vue";

export default {
    components: { imagePreviewSingleEdit },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                image: null,
            },
            image: null
        };
    },
    methods: {
        submitForm() {
            this.loader(true)
            axios
                .put(`/general-settings/default-image-update/`, this.form)
                .then((response) => {
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    this.loader(false)
                    console.log(error.response);
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                })
                .finally(() => {
                    this.loader(false)
                    this.setDefaultImageData();
                });
        },

    },
    created() {
        this.image = this.noImage();
    }
}
</script>
