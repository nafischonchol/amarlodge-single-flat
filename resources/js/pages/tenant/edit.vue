
<template>
  <main class="page-content">
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class="card">
          <div class="card-header py-3 bg-transparent">
            <div class="d-sm-flex align-items-center">
              <h5 class="mb-2 mb-sm-0 align-items-left">Tenant Edit</h5>
              <div class="ms-auto">
                <router-link :to="{ name: 'tenant.list' }" class="btn btn-secondary m-1">
                  {{ translate('Tenant') }} {{ translate('List') }}
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
                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Building') }} {{ translate('Name')
                        }}</label>
                        <select name="building_id" class="form-control" v-model="form.building_id" @change="fetchFlat">
                          <option selected value="">{{ translate('Choose') }}</option>
                          <option v-for="building in buildingList" :key="building.id" :value="building.id">
                            {{ building.name }}
                          </option>
                        </select>
                        <span v-if="allErrors.has('building_id')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('building_id')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Flat') }}</label>
                        <select name="flat_id" class="form-control" v-model="form.flat_id">
                          <option selected value="">{{ translate('Choose') }}</option>
                          <option v-for="flat in flatList" :key="flat.id" :value="flat.id">{{
                            flat.name }}</option>
                        </select>
                        <span v-if="allErrors.has('flat_id')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('flat_id')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label"> {{ translate('Tenant') }} {{ translate('Name')
                        }}</label><span class="text-danger">*</span>
                        <input name="name" type="text" class="form-control" v-model="form.name" />
                        <span v-if="allErrors.has('name')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('name')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Mobile') }} </label><span class="text-danger">*</span>
                        <input name="mobile" type="number" class="form-control" :placeholder="translate('Mobile')"
                          v-model="form.mobile" />
                        <span v-if="allErrors.has('mobile')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('mobile')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Email') }} </label><span class="text-danger">*</span>
                        <input name="email" type="email" class="form-control" :placeholder="translate('Email')"
                          v-model="form.email" />
                        <span v-if="allErrors.has('email')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('email')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Permanent Address') }}</label><span
                          class="text-danger">*</span>
                        <input name="address" type="text" class="form-control" :placeholder="translate('Address')"
                          v-model="form.address" />
                        <span v-if="allErrors.has('address')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('address')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('NID') }}</label><span class="text-danger">*</span>
                        <input name="nid" type="text" class="form-control" :placeholder="translate('NID')"
                          v-model="form.nid" />
                        <span v-if="allErrors.has('nid')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('nid')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">
                          {{ translate('Total') }} {{ translate("Family Member") }}
                        </label>
                        <span class="text-danger">*</span>
                        <input name="member" type="number" class="form-control" :placeholder="translate('Member')"
                          v-model="form.member" />
                        <span v-if="allErrors.has('member')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('member')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Advanced Amount') }}</label>
                        <input name="advanced_amount" type="number" class="form-control"
                          :placeholder="translate('Advanced Amount')" v-model="form.advanced_amount" readonly />
                        <span v-if="allErrors.has('advanced_amount')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('advanced_amount')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Rent') }} per {{ translate('Month') }}</label><span
                          class="text-danger">*</span>
                        <input name="rent_per_month" type="number" class="form-control" placeholder="Rent per Month"
                          v-model="form.rent_per_month" readonly />
                        <span v-if="allErrors.has('rent_per_month')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('rent_per_month')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Issue Date') }}</label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="issue_date" v-model="form.issue_date" />

                        <span v-if="allErrors.has('issue_date')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('issue_date')"></span>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="form-label">{{ translate('Rent Month') }}</label><span class="text-danger">*</span>
                        <input type="month" class="form-control" name="rent_month" v-model="form.rent_month" />
                        <span v-if="allErrors.has('rent_month')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('rent_month')"></span>
                      </div>

                      <div class="col-md-12 col-md-12 col-sm-12">
                        <label class="form-label">{{ translate('Additional Notes') }}</label>
                        <textarea class="form-control" :placeholder="translate('Additional Notes')" rows="4" cols="4"
                          name="additional_notes" v-model="form.additional_notes"></textarea>
                        <span v-if="allErrors.has('additional_notes')" class="error text-danger text-bold ms-2 mt-2"
                          v-text="allErrors.get('additional_notes')"></span>
                      </div>

                      <imagePreviewSingleEdit :form="form" :allErrors="allErrors" :image="image" isRequired="true" />

                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <button class="form-control btn btn-primary" type="submit" :disabled="isLoading">{{
                          translate('Submit') }}</button>
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
import imagePreviewSingleEdit from "@/components/imagePreviewSingleEdit.vue";

export default {
  components: { imagePreviewSingleEdit },
  data() {
    return {
      allErrors: new Errors(),
      toast: useToast(),
      form: {},
      image: null,
      tenant_id: this.$route.params.id,
      buildingList: [],
      flatList: [],
    };
  },
  methods:
  {
    fetchData() {
      axios
        .get(`/tenants/${this.tenant_id}`)
        .then((response) => {
          this.form = response.data;
          this.image = "/" + this.form.image;
          this.form.image = null;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fetchBuilding() {
      axios
        .get("/buildings/all")
        .then((response) => {
          this.buildingList = response.data;
          this.fetchFlat();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fetchFlat() {
      this.flatList = [];
      const building_id = this.form.building_id;
      if (building_id) {
        axios
          .get(`/flats/available-and-selected/building-wise/${building_id}/${this.tenant_id}`)
          .then((response) => {
            this.flatList = response.data;
          })
          .catch((error) => {
            console.error(error);
          });
      }

    },
    submitForm() {
      this.loader(true)
      axios
        .put(`/tenants/${this.tenant_id}`, this.form)
        .then((response) => {
          this.loader(false)
          this.toast.success(response.data);
          this.$router.push({ name: 'tenant.list' });
        })
        .catch((error) => {
          this.loader(false)
          console.log(error.response.data);
          if (error && error.response.status === 422) {
            this.allErrors.record(error.response.data);
          }
          else {
            this.toast.error(error.response.data);
          }
        });
    },
  },
  mounted() {
    this.fetchData();
    this.fetchBuilding();
  }
};
</script>
