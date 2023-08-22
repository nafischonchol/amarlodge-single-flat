<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left"> {{ translate('Edit') }} {{ translate('list') }}</h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'role.list' }" class="btn btn-secondary m-1">
                                    {{ translate('Role') }} {{ translate('List') }}
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
                                            <div class="col-lg-1 col-md-1 col-sm-0"></div>
                                            <div class="col-lg-10 col-md-10 col-sm-12">
                                                <label class="form-label">{{ translate('Role') }} {{ translate('Name')
                                                }}</label><span class="text-danger">*</span>
                                                <input name="name" type="text" class="form-control" placeholder="Role Name"
                                                    v-model="form.name" />
                                                <span v-if="this.allErrors.has('name')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('name')">
                                                </span>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-1"></div>
                                            <div class="col-lg-6 col-md-6 col-sm-10">
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

export default {
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                name: ""
            },
            role_id: this.$route.params.id,
        };
    },
    methods:
    {
        fetchData() {
            axios
                .get(`/rbac/roles/${this.role_id}/edit`)
                .then((response) => {
                    this.form = response.data;
                })
                .catch((error) => {
                    this.toast.error("Something goes wrong!");
                });
        },
        submitForm() {
            this.loader(true)
            axios
                .put(`/rbac/roles/${this.role_id}`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'role.list' });
                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        console.log(error.response.data);
                        this.toast.error("Something goes wrong!");
                    }
                });
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>
