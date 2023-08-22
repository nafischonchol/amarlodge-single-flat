<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Add') }} {{ translate('New') }} {{
                                translate('Cost') }}
                            </h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'flat.cost.list' }" class="btn btn-secondary m-1">
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
                                                <label class="form-label">{{ translate('Date') }} </label> <span
                                                    class="text-danger">*</span>
                                                <input name="date" type="date" class="form-control" v-model="form.date" />
                                                <span v-if="this.allErrors.has('date')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('date')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Cause') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="cause" type="text" class="form-control" v-model="form.cause" />
                                                <span v-if="this.allErrors.has('cause')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('cause')">
                                                </span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Amount') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="amount" type="number" class="form-control"
                                                    v-model="form.amount" />
                                                <span v-if="this.allErrors.has('amount')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="this.allErrors.get('amount')">
                                                </span>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-lg-6 mb-2">
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit"
                                                    :disabled="isLoading">{{
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

export default {
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                date: null,
                cause: "",
                amount: 0,
                payment_method: "",
                recevier_number: "",
                transection_id: "",
                from_account: "",
                to_account: "",
                bank_type: "",
            },
            bankList: [],
            bank_type: "",
        };
    },
    methods:
    {
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
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm() {
            this.loader(true)

            axios
                .post("/flat-costs", this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'flat.cost.list' });
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
        this.fetchBank();
        const currentDate = new Date();
        this.form.date = currentDate.toISOString().slice(0, 10);
    },
};
</script>
