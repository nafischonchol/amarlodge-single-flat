<template>
  <main class="page-content">
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class="card">
          <div class="card-header py-3 bg-transparent">
            <div class="d-sm-flex align-items-center">
              <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Edit') }} {{ translate('Building') }}
              </h5>
              <div class="ms-auto">
                <router-link :to="{ name: 'building.list' }" class="btn btn-secondary m-1">{{
                  translate('Building') }}
                  {{ translate('List') }}</router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shadow-none bg-light border">
                  <div class="card-body">
                    <form @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm" class="row g-3">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <label class="form-label">{{ translate('Building') }} {{ translate('Name')
                        }}</label>
                        <span class="text-danger">*</span>
                        <input class="form-control" name="name" placeholder="Name" type="text" v-model="form.name" />
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('name')"
                          v-text="this.allErrors.get('name')"></span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('Contact') }} {{ translate('Name')
                        }}</label>
                        <span class="text-danger">*</span>
                        <input class="form-control" name="contact_name" type="text" v-model="form.contact_name" />
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('contact_name')"
                          v-text="this.allErrors.get('contact_name')"></span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('Contact') }} {{ translate('Number')
                        }}</label>
                        <span class="text-danger">*</span>
                        <input class="form-control" name="contact_number" type="text" v-model="form.contact_number" />
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('contact_number')"
                          v-text="this.allErrors.get('contact_number')"></span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('Floor') }}</label>
                        <span class="text-danger">*</span>
                        <input class="form-control" name="floor" placeholder="Floor" type="number" v-model="form.floor" />
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('floor')"
                          v-text="this.allErrors.get('floor')"></span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">Lift</label>
                        <select class="form-control" name="lift" v-model="form.lift">
                          <option value>Choose</option>
                          <option value="1">Yes</option>
                          <option value="0">No</option>
                        </select>
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('lift')"
                          v-text="this.allErrors.get('lift')"></span>
                      </div>

                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('Staff') }}</label>
                        <v-select :options="staffList" label="name" multiple placeholder="Choose"
                          v-model="selectedStaff"></v-select>
                      </div>
                      <LocationPickerEdit :allErrors="allErrors" :form="form" colDef="col-lg-6 col-md-6 col-sm-12" />

                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('Street') }}</label>
                        <input class="form-control" name="street" placeholder="Street address" type="text"
                          v-model="form.street" />
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('street')"
                          v-text="this.allErrors.get('street')"></span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('Post Code') }}</label>
                        <input class="form-control" name="post_code" placeholder="{{ translate('Post Code') }}"
                          type="text" v-model="form.post_code" />
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('post_code')"
                          v-text="this.allErrors.get('post_code')"></span>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">{{ translate('House') }} {{ translate('Number')
                        }}</label>
                        <input class="form-control" name="house_number"
                          placeholder="{{ translate('House') }} {{ translate('Number') }}" type="text"
                          v-model="form.house_number" />
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('house_number')"
                          v-text="this.allErrors.get('house_number')"></span>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <label class="form-label">{{ translate('Details Info') }} </label>
                        <textarea class="form-control" cols="4" name="details_info" placeholder="Details Info" rows="4"
                          v-model="form.details_info"></textarea>
                        <span class="error text-danger text-bold ms-2 mt-2" v-if="this.allErrors.has('details_info')"
                          v-text="this.allErrors.get('details_info')"></span>
                      </div>
                      <imagePreviewEdit :allErrors="allErrors" :form="form" :image="image" :images="images" />
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <button class="form-control btn btn-primary" type="submit" :disabled="isLoading">{{
                          translate('Submit') }} </button>

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
import imagePreviewEdit from "@/components/imagePreviewEdit.vue";
import LocationPickerEdit from "@/components/LocationPickerEdit.vue";

export default {
  components: { imagePreviewEdit, LocationPickerEdit },
  data() {
    return {
      allErrors: new Errors(),
      toast: useToast(),
      form: {
        name: "",
        contact_name: "",
        contact_number: "",
        floor: "",
        lift: "",
        staff_id: [],
        full_address: "",
        details_info: ""
      },
      image: null,
      images: [],
      buildingId: this.$route.params.id,
      staffList: [],
      selectedStaff: []
    };
  },
  methods: {
    handleSubmit() {
      this.form.staff_id = this.selectedStaff.map(staff => staff.id);
    },
    submitForm() {
      this.loader(true)
      this.handleSubmit();
      axios
        .put(`/buildings/${this.buildingId}`, this.form)
        .then(response => {
          this.loader(false)
          this.toast.success(response.data);
          this.$router.push("/building/list");
        })
        .catch(error => {
          this.loader(false)
          if (error && error.response.status === 422) {
            this.allErrors.record(error.response.data);
          } else {
            this.toast.error(error.response.data);
          }
        });
    },
    fetchData() {
      axios
        .get(`/buildings/${this.buildingId}`)
        .then(response => {
          this.form = response.data;
          this.selectedStaff = response.data.staff;
          this.image = "/" + this.form.image;
          this.images = JSON.parse(this.form.images);
          this.form.image = null;
          this.form.images = null;
        })
        .catch(error => {
          console.log("Something goes wrong!");
        });
    },
    fetchStaff() {
      axios
        .get("/staffs/all")
        .then(response => {
          this.staffList = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    }
  },

  mounted() {
    this.fetchData();
    this.fetchStaff();
  }
};
</script>
