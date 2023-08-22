<template>
  <main class="page-content">
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class="card">
          <div class="card-header py-3 bg-transparent">
            <div class="d-sm-flex align-items-center">
              <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('New') }} {{ translate('Users') }}</h5>
              <div class="ms-auto">
                <router-link :to="{ name: 'user.list' }" class="btn btn-secondary m-1">
                  {{ translate('Users') }} {{ translate('List') }}
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-12 col-md-12 col-sm-12">
                <div class="card shadow-none bg-light border">
                  <div class="card-body">
                    <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label"> {{ translate('Name') }}</label> <span class="text-danger">*</span>
                        <input name="name" type="text" class="form-control" v-model="form.name" />
                        <span v-if="this.allErrors.has('name')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('name')">
                        </span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label"> {{ translate('Email') }}</label> <span class="text-danger">*</span>
                        <input name="email" type="text" class="form-control" v-model="form.email" />
                        <span v-if="this.allErrors.has('email')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('email')">
                        </span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label"> {{ translate('Password') }}</label> <span class="text-danger">*</span>
                        <input name="password" type="text" class="form-control" v-model="form.password" />
                        <span v-if="this.allErrors.has('password')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('password')">
                        </span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label"> {{ translate('Role') }}</label>
                        <select name="role_id" class="form-control" v-model="form.role_id">
                          <option value="">{{ translate('Choose') }}</option>
                          <option v-for="role in roles" :key="role.id" :value="role.id">{{
                            role.name }}</option>
                        </select>
                        <span v-if="this.allErrors.has('role_id')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('role_id')">
                        </span>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <button class="form-control btn btn-primary" type="submit" :disabled="isLoading">
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
        role_id: "",
        password: "",
        email: "",
        name: "",
      },
      roles: []
    };
  },
  methods:
  {
    submitForm() {
      this.loader(true);
      axios
        .post("/rbac/users", this.form)
        .then((response) => {
          this.loader(false);
          this.toast.success(response.data);
          this.$router.push({ name: 'user.list' });
        })
        .catch((error) => {
          this.loader(false);
          if (error && error.response.status === 422) {
            this.allErrors.record(error.response.data);
          }
          else {
            console.log(error.response.data);
            this.toast.error("Something goes wrong!");
          }
        })
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
    }
  },
  created() {
    this.fetchRole();
  }
};
</script>
