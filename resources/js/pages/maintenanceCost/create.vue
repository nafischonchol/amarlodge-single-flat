
<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Maintenance Cost') }} {{
                                translate('Add') }} </h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'maintenance.list' }" class="btn btn-secondary m-1">
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
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Building') }}</label> <span
                                                    class="text-danger">*</span>
                                                <select name="building_id" class="form-control" v-model="form.building_id"
                                                    @change="handlePayerChange">
                                                    <option selected value="">{{ translate('Choose') }}</option>
                                                    <option v-for="building in buildingList" :key="building.id"
                                                        :value="building.id">
                                                        {{ building.name }}
                                                    </option>
                                                </select>
                                                <span v-if="allErrors.has('building_id')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('building_id')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Date') }} </label> <span
                                                    class="text-danger">*</span>
                                                <input name="date" class="form-control" v-model="form.date" type="date"
                                                    readonly />
                                                <span v-if="allErrors.has('date')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('date')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Maintenance') }} {{
                                                    translate('Title') }}</label> <span class="text-danger">*</span>
                                                <input name="title" class="form-control" v-model="form.title" type="text" />
                                                <span v-if="allErrors.has('title')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('title')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Amount') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="amount" class="form-control" v-model="form.amount"
                                                    type="number" @change="handlePayerAmount" />
                                                <span v-if="allErrors.has('amount')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('amount')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Details') }} </label>
                                                <textarea name="details" class="form-control"
                                                    v-model="form.details"></textarea>
                                                <span v-if="allErrors.has('details')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('details')"></span>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-lg-3 mb-2">
                                                <label class="form-label">{{ translate('Payment') }} {{ translate('Method')
                                                }}</label> <span class="text-danger">*</span>
                                                <select name="payment_method" class="form-control"
                                                    v-model="form.payment_method" @change="updatePaymentMethod">
                                                    <option value="">{{ translate('Choose') }}</option>
                                                    <option value="Cash">Cash</option>
                                                    <option v-for="bank in bankList" :key="bank.id" :value="bank.bank_name">
                                                        {{ bank.bank_name }}
                                                    </option>
                                                </select>
                                                <span v-if="allErrors.has('payment_method')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('payment_method')"></span>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-lg-3">
                                                <label class="form-label">{{ translate('Bill') }} {{ translate('Payer')
                                                }}</label><span class="text-danger">*</span><br />
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" type="radio" id="inlineCheckbox1"
                                                        name="bill_payer" value="Owner" v-model="form.bill_payer"
                                                        @change="handlePayerChange">
                                                    <label class="form-check-label">Owner</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="inlineCheckbox2"
                                                        value="Flat" name="bill_payer" v-model="form.bill_payer"
                                                        @change="handlePayerChange">
                                                    <label class="form-check-label"> Flat </label>
                                                </div>
                                                <p v-if="allErrors.has('bill_payer')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('bill_payer')"></p>
                                            </div>
                                            <template v-if="bank_type === 'Mobile Bank'">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <label class="form-label">{{ translate('Receiver Mobile Number')
                                                    }}</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" name="recevier_number"
                                                        v-model="form.recevier_number" />
                                                    <span v-if="allErrors.has('recevier_number')"
                                                        class="error text-danger text-bold ms-2 mt-2"
                                                        v-text="allErrors.get('recevier_number')"></span>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <label class="form-label">{{ translate('Transection ID') }}</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="transection_id"
                                                        v-model="form.transection_id" />
                                                    <span v-if="allErrors.has('transection_id')"
                                                        class="error text-danger text-bold ms-2 mt-2"
                                                        v-text="allErrors.get('transection_id')"></span>
                                                </div>
                                            </template>
                                            <template v-if="bank_type === 'Traditional Bank'">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <label class="form-label">{{ translate('From Account') }}</label> <span
                                                        class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="from_account"
                                                        v-model="form.from_account" />
                                                    <span v-if="allErrors.has('from_account')"
                                                        class="error text-danger text-bold ms-2 mt-2"
                                                        v-text="allErrors.get('from_account')"></span>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <label class="form-label">{{ translate('To Account') }}</label> <span
                                                        class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="to_account"
                                                        v-model="form.to_account" />
                                                    <span v-if="allErrors.has('to_account')"
                                                        class="error text-danger text-bold ms-2 mt-2"
                                                        v-text="allErrors.get('to_account')"></span>
                                                </div>
                                            </template>

                                            <div class="col-md-3 col-sm-12 col-lg-3" v-if="bookedFlats.length > 0">
                                                <label class="form-label">{{ translate('Select') }} {{ translate('Flat')
                                                }}</label> <span class="text-danger">*</span>
                                                <div class="form-check" v-for="flat in bookedFlats" :key="flat.id">
                                                    <input class="form-check-input" type="checkbox" :value="flat.id"
                                                        id="flexCheckChecked" v-model="form.checked_flats"
                                                        @change="handlePayerAmount">
                                                    <label class="form-check-label">{{ flat.name + " - " + per_flat_amount
                                                    }}</label>
                                                </div>
                                            </div>
                                            <div class="display-block">
                                                <imagePreviewSingle :form="form" :allErrors="allErrors"
                                                    title="Receipt Image" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit"
                                                    :disabled="isLoading">{{
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
import imagePreviewSingle from "@/components/imagePreviewSingle.vue";

export default {
    components: { imagePreviewSingle },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                building_id: "",
                title: "",
                date: null,
                amount: 0,
                details: "",
                image: "",
                payment_method: "",
                recevier_number: "",
                transection_id: "",
                from_account: "",
                to_account: "",
                bank_type: "",
                bill_payer: "",
                checked_flats: [],
            },
            buildingList: [],
            bankList: [],
            bank_type: "",
            bookedFlats: [],
            per_flat_amount: 0,
        };
    },
    methods:
    {
        handlePayerAmount() {
            this.per_flat_amount = 0;
            this.per_flat_amount = (this.form.amount / this.form.checked_flats.length).toFixed(2);
            if (Number.isInteger(parseFloat(this.per_flat_amount))) {
                this.per_flat_amount = parseInt(this.per_flat_amount);
            }
        },
        handlePayerChange() {
            this.form.checked_flats = [];
            this.bookedFlats = [];
            if (this.form.building_id == "")
                this.toast.error("Please choose building!");

            if (this.form.bill_payer == "Flat" && this.form.building_id != "") {
                axios
                    .get(`/flats/building-wise/booked/${this.form.building_id}`)
                    .then((response) => {
                        this.bookedFlats = response.data;
                        this.form.checked_flats = this.bookedFlats.map(flat => flat.id);
                        this.handlePayerAmount();
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
            else {
                this.handlePayerAmount();
            }
        },
        updatePaymentMethod() {
            this.bank_type = null;
            this.form.recevier_number = null;
            this.form.transection_id = null;
            this.form.to_account = null;
            this.form.from_account = null;

            let bankName = this.form.payment_method;
            const foundBank = this.bankList.find(bank => bank.bank_name === bankName);
            if (foundBank)
                this.bank_type = foundBank.bank_type;
        },
        fetchBank() {
            axios
                .get("/setting/bank-setup/all")
                .then((response) => {
                    this.bankList = response.data;
                    console.log(this.bankList)
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
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm() {
            this.loader(true)
            this.form.bank_type = this.bank_type;
            axios
                .post("/maintenance-costs", this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'maintenance.list' });
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

    mounted() {
        this.form.date = this.currentDate();
        this.fetchBuilding();
        this.fetchBank();
    },

};
</script>


