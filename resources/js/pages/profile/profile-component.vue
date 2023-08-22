<template>
    <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">

        <div class="col-lg-6 col-md-6 col-sm-12">
            <label class="form-label">{{ translate('Name') }} </label> <span class="text-danger">*</span>
            <input name="name" type="text" class="form-control" v-model="form.name" />
            <span v-if="this.allErrors.has('name')" class="error text-danger text-bold ms-2 mt-2"
                v-text="this.allErrors.get('name')">
            </span>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label class="form-label">{{ translate('Mobile') }} </label> <span class="text-danger">*</span>
            <input name="mobile" type="text" class="form-control" v-model="form.mobile" />
            <span v-if="this.allErrors.has('mobile')" class="error text-danger text-bold ms-2 mt-2"
                v-text="this.allErrors.get('mobile')">
            </span>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label class="form-label">{{ translate('Email') }} </label> <span class="text-danger">*</span>
            <input name="email" type="email" class="form-control" v-model="form.email" />
            <span v-if="this.allErrors.has('email')" class="error text-danger text-bold ms-2 mt-2"
                v-text="this.allErrors.get('email')">
            </span>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label class="form-label">{{ translate('Role') }}</label>
            <input name="role" type="text" class="form-control" v-model="form.role" readonly />
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label class="form-label"> {{ translate('Address') }}</label>
            <textarea class="form-control" v-model="form.address"></textarea>
            <span v-if="this.allErrors.has('address')" class="error text-danger text-bold ms-2 mt-2"
                v-text="this.allErrors.get('address')">
            </span>
        </div>
        <div class="display-block">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label class="form-label">{{ translate('Image') }}</label>
                <input name="image" type="file" class="form-control" ref="fileInput" @change="onFileChange" />
                <span v-if="this.allErrors.has('image')" class="error text-danger text-bold ms-2 mt-2"
                    v-text="this.allErrors.get('image')">
                </span>
            </div>
            <div class="row mt-3">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="image-container">
                        <img :src="newImage" class="img-preview" alt="" @error="handleImageErrorNoImage($event)">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <button class="form-control btn btn-primary" type="submit">
                {{ translate('Submit') }}
            </button>
        </div>
    </form>
</template>

<script>
import axios from "@/axios-config";
import Errors from "@/errors/errors.js";
import { useToast } from "vue-toastification";
import imagePreviewSingleEdit from "@/components/imagePreviewEdit.vue";
import "@/components/imagePreview.css";
import { userStore } from "@/stores/user.js";
export default {
    components: { imagePreviewSingleEdit },
    data() {
        return {
            auth: userStore(),
            allErrors: new Errors(),
            toast: useToast(),
            form: {
            },
            newImage: null,
            data: []
        };
    },
    methods:
    {
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.form.image = event.target.result;
                this.newImage = this.form.image;
            };
            reader.readAsDataURL(file);
        },
        setUserInfo() {
            axios
                .get(`/user-info`)
                .then((response) => {
                    this.data = response.data;
                    this.data.token = this.auth.getToken;
                    this.auth.setUser(this.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchInfo() {
            axios
                .get(`/user-info`)
                .then((response) => {
                    this.form = response.data;
                    this.newImage = this.form.image ? '/' + this.form.image : this.noImage();
                    this.form.image = null;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm() {
            this.loader(true)
            axios
                .put("/profile-update", this.form)
                .then((response) => {
                    this.loader(false)
                    this.setUserInfo();
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        console.log(error.response.data);
                        this.toast.error(error.response.data);
                    }
                });
        }
    },
    mounted() {
        this.fetchInfo();
    },
};
</script>

