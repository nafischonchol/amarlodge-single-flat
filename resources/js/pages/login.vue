<template>
    <main class="authentication-content">
        <div class="container-fluid">
            <div class="authentication-card">
                <div class="card shadow rounded-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                            <img :src="login_image" class="img-fluid" @error="handleImageErrorNoImage($event)" />
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body p-4 p-sm-5">
                                <h5 class="card-title">Sign In</h5>
                                <p class="card-text mb-5">
                                    See your growth and get consulting support!
                                </p>
                                <form class="form-body" action="#" method="POST"
                                    @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">
                                    <div class="row g-3">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label for="inputEmailAddress" class="form-label"> Email Address
                                            </label>
                                            <div class="ms-auto position-relative">
                                                <input v-model="form.email" type="email" class="form-control radius-30 ps-5"
                                                    id="email" name="email" placeholder="Email Address" />
                                            </div>
                                            <span v-if="this.allErrors.has('email')"
                                                class="error text-danger text-bold ms-2 mt-2"
                                                v-text="this.allErrors.get('email')">
                                            </span>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label for="inputChoosePassword" class="form-label">Enter Password</label>
                                            <div class="ms-auto position-relative">
                                                <input v-model="form.password" type="password"
                                                    class="form-control radius-30 ps-5" id="password" name="password"
                                                    placeholder="Enter Password" autocomplete="on" />
                                            </div>
                                            <span v-if="this.allErrors.has('password')"
                                                class="error text-danger text-bold ms-2 mt-2"
                                                v-text="this.allErrors.get('password')">
                                            </span>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <a href="#">Forgot Password ?</a>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary radius-30">
                                                    Sign In
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p class="mb-0">
                                                Don't have an account yet?
                                                <span>Sign up here</span>
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "@/axios-config";
import Errors from "@/errors/errors.js";
import { useToast } from "vue-toastification";
import { userStore } from "@/stores/user.js";

export default {
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            auth: userStore(),
            form: {
                email: "",
                password: "",
            },
            login_image: "/theme/images/error/login-img.jpg",
        };
    },
    methods: {
        async submitForm() {
            this.loader(true)
            try {
                const response = await axios.post("/login", this.form);

                if (response.data.status === 200) {
                    this.loader(false)
                    let data = response.data.data;
                    this.auth.setUser(data);
                    this.toast.success(response.data.message);

                    this.$router.push({ name: 'home' });
                } else {
                    this.toast.error(response.data.message);
                }
            } catch (error) {
                this.loader(false)
                if (error && error.response.status === 422) {
                    this.allErrors.record(error.response.data);
                } else if (error.response.status === 401) {
                    this.toast.error(error.response.data.message);
                } else {
                    this.toast.error("Login failed!");
                }
            }
        },
    }
};
</script>
