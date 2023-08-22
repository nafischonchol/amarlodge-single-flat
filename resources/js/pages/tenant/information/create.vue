
<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">{{ translate('Information') }} {{ translate('Add') }}</h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'tenant.information.list' }" class="btn btn-secondary m-1">
                                    {{ translate('List') }}
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
                                            <h6 class="text-secondary">{{ translate('Primary') }} {{
                                                translate('Information') }}</h6>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Name") }}</label>
                                                <input name="name" type="text" class="form-control" v-model="form.name" />
                                                <span v-if="allErrors.has('name')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('name')"></span>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Father") }} {{ translate("Name")
                                                }}</label>
                                                <input name="father_name" type="text" class="form-control"
                                                    v-model="form.father_name" />
                                                <span v-if="allErrors.has('father_name')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('father_name')"></span>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Birth Date") }}</label>
                                                <input name="dob" type="date" class="form-control" v-model="form.dob" />
                                                <span v-if="allErrors.has('dob')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('dob')"></span>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Marital Status") }}</label>
                                                <select name="marital_status" class="form-control"
                                                    v-model="form.marital_status">
                                                    <option value="">{{ translate('Choose') }}</option>
                                                    <option>Married</option>
                                                    <option>Bachelor</option>
                                                    <option>Divorced</option>
                                                    <option>Other</option>
                                                </select>
                                                <span v-if="allErrors.has('marital_status')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('marital_status')"></span>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Permanent Address") }}</label>
                                                <input name="permanent_address" type="text" class="form-control"
                                                    v-model="form.permanent_address" />
                                                <span v-if="allErrors.has('permanent_address')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('permanent_address')"></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Profession") }}</label>
                                                <input name="profession" type="text" class="form-control"
                                                    v-model="form.profession" />
                                                <span v-if="allErrors.has('profession')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('profession')"></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Institute") }} {{
                                                    translate("Address") }}</label>
                                                <input name="institute_address" type="text" class="form-control"
                                                    v-model="form.institute_address" />
                                                <span v-if="allErrors.has('institute_address')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('institute_address')"></span>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Religion") }}</label>
                                                <select name="religion" class="form-control" v-model="form.religion">
                                                    <option value="">{{ translate('Choose') }}</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Christianity">Christianity</option>
                                                    <option value="Hinduism">Hinduism</option>
                                                    <option value="Buddhism">Buddhism</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <span v-if="allErrors.has('religion')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('religion')"></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Educational Qualification")
                                                }}</label>
                                                <input name="educational_qualification" type="text" class="form-control"
                                                    v-model="form.educational_qualification" />
                                                <span v-if="allErrors.has('educational_qualification')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('educational_qualification')"></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Mobile") }}</label>
                                                <input name="mobile" type="text" class="form-control"
                                                    v-model="form.mobile" />
                                                <span v-if="allErrors.has('mobile')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('mobile')"></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("Email") }}</label>
                                                <input name="email" type="email" class="form-control"
                                                    v-model="form.email" />
                                                <span v-if="allErrors.has('email')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('email')"></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label">{{ translate("NID") }}</label>
                                                <input name="nid" type="text" class="form-control" v-model="form.nid" />
                                                <span v-if="allErrors.has('nid')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('nid')"></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="form-label"> {{ translate('Passport Number') }} ({{
                                                    translate('If available') }})</label>
                                                <input name="passport_number" type="text" class="form-control"
                                                    v-model="form.passport_number" />
                                                <span v-if="allErrors.has('passport_number')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('passport_number')"></span>
                                            </div>
                                            <hr />
                                            <h6 class="text-secondary">{{ translate('Emergency Contact') }}</h6>

                                            <div class="col-sm-12 col-lg-3 col-md-3">
                                                <label class="form-label">{{ translate("Name") }}</label>
                                                <input name="emergency_name" type="text" class="form-control"
                                                    v-model="form.emergency_name" />
                                                <span v-if="allErrors.has('emergency_name')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('emergency_name')"></span>
                                            </div>

                                            <div class="col-sm-12 col-lg-3 col-md-3">
                                                <label class="form-label">{{ translate("Address") }}</label>
                                                <input name="emergency_address" type="text" class="form-control"
                                                    v-model="form.emergency_address" />
                                                <span v-if="allErrors.has('emergency_address')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('emergency_address')"></span>
                                            </div>
                                            <div class="col-sm-12 col-lg-3 col-md-3">
                                                <label class="form-label">{{ translate("Mobile") }}</label>
                                                <input name="emergency_mobile" type="text" class="form-control"
                                                    v-model="form.emergency_mobile" />
                                                <span v-if="allErrors.has('emergency_mobile')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('emergency_mobile')"></span>
                                            </div>
                                            <div class="col-sm-12 col-lg-3 col-md-3">
                                                <label class="form-label">{{ translate("Relation To You") }}</label>
                                                <input name="emergency_relation" type="text" class="form-control"
                                                    v-model="form.emergency_relation" />
                                                <span v-if="allErrors.has('emergency_relation')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('emergency_relation')"></span>
                                            </div>
                                            <hr />
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="text-secondary">{{ translate('Family Member Details') }}</h6>

                                                </div>
                                                <div>
                                                    <p @click="addRow" class="btn btn-primary btn-sm">{{ translate('Add') }}
                                                        {{ translate('Member') }}</p>
                                                </div>
                                            </div>
                                            <template v-for="(row, index) in family_members" :key="index">
                                                <div class="col-sm-12 col-lg-3 col-md-3">
                                                    <label class="form-label">{{ translate("Name") }}</label>
                                                    <input name="member_name" type="text" class="form-control"
                                                        v-model="row.member_name" />
                                                    <span v-if="errorMessages['family_members.' + index + '.member_name']"
                                                        class="error text-danger text-bold ms-2 mt-2">Name is
                                                        requred</span>
                                                </div>
                                                <div class="col-sm-12 col-lg-2 col-md-2">
                                                    <label class="form-label">{{ translate('Age') }}</label>
                                                    <input name="member_age" type="number" class="form-control"
                                                        v-model="row.member_age" />
                                                    <span v-if="errorMessages['family_members.' + index + '.member_age']"
                                                        class="error text-danger text-bold ms-2 mt-2">Age is required</span>
                                                </div>
                                                <div class="col-sm-12 col-lg-3 col-md-3">
                                                    <label class="form-label">{{ translate("Profession") }}</label>
                                                    <input name="member_profession" type="text" class="form-control"
                                                        v-model="row.member_profession" />
                                                    <span
                                                        v-if="errorMessages['family_members.' + index + '.member_profession']"
                                                        class="error text-danger text-bold ms-2 mt-2"
                                                        v-text="errorMessages['family_members.' + index + '.member_profession']"></span>
                                                </div>
                                                <div class="col-sm-12 col-lg-3 col-md-3">
                                                    <label class="form-label">{{ translate("Mobile") }}</label>
                                                    <input name="member_mobile" type="text" class="form-control"
                                                        v-model="row.member_mobile" />
                                                    <span v-if="errorMessages['family_members.' + index + '.member_mobile']"
                                                        class="error text-danger text-bold ms-2 mt-2"
                                                        v-text="errorMessages['family_members.' + index + '.member_mobile']"></span>
                                                </div>

                                                <div class="col-sm-12 col-lg-1 col-md-1" v-show="index > 0">
                                                    <br />
                                                    <div class="button mt-2">
                                                        <p @click="removeRow(index)" class="btn btn-outline-danger btn-sm">
                                                            {{ translate('Remove') }}</p>
                                                    </div>
                                                </div>
                                            </template>

                                            <imagePreviewSingle :form="form" :allErrors="allErrors" title="Your Image" />

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit"
                                                    :disabled="isLoading"> Submit </button>
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
import imagePreviewSingle from "@/components/imagePreviewSingle.vue";

export default {
    components: { imagePreviewSingle },
    data() {
        return {
            allErrors: new Errors(),
            errorMessages: {},
            toast: useToast(),
            form: {
                name: "",
                father_name: "",
                dob: new Date().toISOString().substr(0, 10),
                marital_status: "",
                permanent_address: "",
                profession: "",
                institute_address: "",
                religion: "",
                educational_qualification: "",
                mobile: "",
                email: "",
                nid: "",
                passport_number: "",
                emergency_name: "",
                emergency_mobile: "",
                emergency_address: "",
                emergency_relation: "",
                image: "",
                family_members: null,
            },
            family_members: [
                { member_name: '', member_age: '', member_profession: '', member_mobile: '' }
            ]
        };
    },
    methods:
    {
        addRow() {
            this.family_members.push({ member_name: '', member_age: '', member_profession: '', member_mobile: '' });
        },
        removeRow(index) {
            this.family_members.splice(index, 1);
        },
        submitForm() {
            this.form.family_members = this.family_members;
            axios
                .post("/tenant-informations", this.form)
                .then((response) => {
                    this.toast.success(response.data);
                    this.$router.push({ name: 'tenant.information.list' });
                })
                .catch((error) => {
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                        this.errorMessages = error.response.data;
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
    }
};
</script>
