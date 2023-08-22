<template>
    <div class="modal fade" id="user-access-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"> {{ translate('Add new User Access') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="confirmRole">

                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label"> {{ translate('User') }}</label>
                            <select name="user_id" class="form-control" v-model="form.user_id">
                                <option value=""> {{ translate('Choose') }}</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                            </select>
                            <span v-if="this.allErrors.has('user_id')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('user_id')">
                            </span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                            <label class="form-label">{{ translate('Role') }}</label>
                            <select name="role_id" class="form-control" v-model="form.role_id">
                                <option value="">{{ translate('Choose') }}</option>
                                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                            </select>
                            <span v-if="this.allErrors.has('role_id')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('role_id')">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ translate('Cancel')
                        }}</button>
                        <button class="btn btn-primary" type="submit"> {{ translate('Submit') }}</button>
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
                user_id: "",
                role_id: "",
            },
            users: [],
            roles: []
        };
    },
    methods: {
        confirmRole() {
            this.loader(true)
            axios
                .post("/rbac/user-access", this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    $("#user-access-modal").modal("hide");
                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data.errors);
                    }
                    else {
                        console.log(error.response.data);
                        this.toast.error("Something goes wrong!");
                    }
                });
        },
        fetchRole() {
            axios
                .get("/rbac/roles/all")
                .then((response) => {
                    this.roles = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchUser() {
            axios
                .get("/rbac/users/all")
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    },
    mounted() {
        this.fetchUser();
        this.fetchRole();
    },

}
</script>
