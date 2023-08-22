<template>
    <div class="card-body">

        <form class="row g-3 mt-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">


            <div class="col-md-4 col-lg-4 mb-2">
                <label class="form-label">{{ translate('Payment') }} {{ translate('Method') }}</label> <span
                    class="text-danger">*</span>
                <select name="payment_method" class="form-control" v-model="form.payment_method"
                    @change="updatePaymentMethod">
                    <option value="">{{ translate('Choose') }}</option>
                    <option value="Cash">Cash</option>
                    <option v-for="     bank      in      bankList     " :key="bank.id" :value="bank.bank_name">
                        {{ bank.bank_name }}
                    </option>
                </select>
                <span v-if="allErrors.has('payment_method')" class="error text-danger text-bold ms-2 mt-2"
                    v-text="allErrors.get('payment_method')"></span>
            </div>
            <div class="col-md-4 col-lg-4">
                <label class="form-label">{{ translate('Total') }} {{ translate('Amount') }}</label>
                <input name="amount" class="form-control" v-model="form.total_amount" type="number" readonly />
            </div>

            <div class="col-md-4 col-lg-4">
                <label class="form-label">{{ translate('Current') }} {{ translate('Advanced Amount') }}</label>
                <input name="advanced_amount" class="form-control" v-model="form.advanced_amount" type="number" readonly />
            </div>
            <template v-if="bank_type === 'Mobile Bank'">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label class="form-label">{{ translate('Receiver Mobile Number') }}</label> <span
                        class="text-danger">*</span>
                    <input type="number" class="form-control" name="receiver_number" v-model="form.receiver_number" />
                    <span v-if="allErrors.has('receiver_number')" class="error text-danger text-bold ms-2 mt-2"
                        v-text="allErrors.get('receiver_number')"></span>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label class="form-label">{{ translate('Transection ID') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="transaction_id" v-model="form.transaction_id" />
                    <span v-if="allErrors.has('transaction_id')" class="error text-danger text-bold ms-2 mt-2"
                        v-text="allErrors.get('transaction_id')"></span>
                </div>
            </template>
            <template v-if="bank_type === 'Traditional Bank'">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label class="form-label">{{ translate('From Account') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="from_account" v-model="form.from_account" />
                    <span v-if="allErrors.has('from_account')" class="error text-danger text-bold ms-2 mt-2"
                        v-text="allErrors.get('from_account')"></span>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label class="form-label">{{ translate('To Account') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="to_account" v-model="form.to_account" />
                    <span v-if="allErrors.has('to_account')" class="error text-danger text-bold ms-2 mt-2"
                        v-text="allErrors.get('to_account')"></span>
                </div>
            </template>
            <div class="col-md-4 col-lg-4">
                <label class="form-label">{{ translate('Discount') }} {{ translate('Amount') }}</label>
                <input name="discount_amount" class="form-control" v-model="form.discount_amount" type="number"
                    step="any" />
                <span v-if="allErrors.has('discount_amount')" class="error text-danger text-bold ms-2 mt-2"
                    v-text="allErrors.get('discount_amount')"></span>
            </div>
            <div class="col-md-4 col-lg-4">
                <label class="form-label"> {{ translate('Use Advanced Amount') }}</label>
                <input name="use_advanced_amount" class="form-control" v-model="form.use_advanced_amount" type="number" />
                <span v-if="allErrors.has('use_advanced_amount')" class="error text-danger text-bold ms-2 mt-2"
                    v-text="allErrors.get('use_advanced_amount')"></span>
            </div>
            <div class="col-md-4 col-lg-4">
                <label class="form-label">{{ translate('Pay') }} {{ translate('Amount') }}</label>
                <input name="pay_amount" class="form-control" v-model="payAmount" type="number" readonly />
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                <button class="form-control btn btn-primary" type="submit" :disabled="isLoading">{{ translate('Pay')
                }}</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
import Errors from "@/errors/errors.js";
export default {
    props: {
        prop_total_amount: {
            type: String,
            required: true,
        },
        prop_checked_bills:
        {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                checked_bills: [],
                total_amount: 0,
                discount_amount: 0,
                advanced_amount: 0,
                use_advanced_amount: 0,
                pay_amount: 0,
                payment_method: "",
                receiver_number: "",
                transaction_id: "",
                from_account: "",
                to_account: "",
                bank_type: "",
            },
            checkedBills: [],
            bankList: [],
            bank_type: ""
        };
    },
    watch: {
        prop_total_amount: {
            immediate: true, // Run the watcher immediately when the component is mounted
            handler(newVal) {
                this.form.total_amount = newVal;
            }
        }
    },
    computed: {
        payAmount() {
            if (this.form.use_advanced_amount > this.form.advanced_amount) {
                this.toast.error("Can't be greater than advanced amount!");
                this.form.use_advanced_amount = this.form.advanced_amount;
            }
            this.form.pay_amount = this.form.total_amount - this.form.discount_amount - this.form.use_advanced_amount;
            return this.form.pay_amount.toFixed(2);
        }
    },
    methods: {
        updatePaymentMethod() {
            this.bank_type = null;
            this.form.receiver_number = null;
            this.form.transaction_id = null;
            this.form.to_account = null;
            this.form.from_account = null;

            let bankName = this.form.payment_method;
            const foundBank = this.bankList.find(bank => bank.bank_name === bankName);
            if (foundBank)
                this.bank_type = foundBank.bank_type;
        },
        fetchAdvanceMoney() {
            axios
                .get("/my-advanced-money")
                .then((response) => {
                    this.form.advanced_amount = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
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
            this.form.checked_bills = this.prop_checked_bills;
            this.form.pay_amount = this.payAmount;
            axios
                .post("/flat-bills-pay", this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'flats.bill.pay.history' });
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
        }
    },
    created() {
        this.fetchBank();
        this.fetchAdvanceMoney();
    }
}
</script>
