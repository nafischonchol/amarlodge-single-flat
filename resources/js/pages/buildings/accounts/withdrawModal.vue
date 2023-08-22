<template>
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Withdraw Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12 col-md-12 col-sm-12">
                            <div class="card shadow-none bg-light border">
                                <div class="card-body">
                                    <form class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label class="form-label">Withdraw From</label>
                                            <select name="bank_type" class="form-control" @change="getCurrentBalance"
                                                v-model="form.bank_type">
                                                <option value="">Select Method</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Traditional Bank">Bank</option>
                                                <option value="Mobile Bank">Mobile Bank</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">{{ translate('Amount') }}</label>
                                            <input name="currentAmount" v-model="form.currentAmount" class="form-control"
                                                readonly placeholder="Current amount">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Withdraw {{ translate('Amount') }}</label>
                                            <input name="withdrawAmount" v-model="form.withdrawAmount" class="form-control">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{
                                        translate('Cancel') }} </button>
                                    <button type="button" class="btn btn-danger" @click="submitForm"> {{
                                        translate('Submit') }} </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
export default {
    data() {
        return {
            toast: useToast(),
            form: {
                bank_type: "",
                currentAmount: null,
                withdrawAmount: 0
            }
        }
    },
    methods: {
        submitForm() {
            $("#withdrawModal").modal("hide");
            axios
                .post("/withdraw", this.form)
                .then((response) => {
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    if (error && error.response.status === 422) {
                        this.$emit('form-submission-failed', error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
        getCurrentBalance() {
            if (this.form.bank_type == "") {
                this.form.currentAmount = 0;
                return true;
            }
            axios
                .get(`/bank-type-wise-current-balance/${this.form.bank_type}`)
                .then((response) => {
                    this.form.currentAmount = response.data;
                })
                .catch((error) => {
                    this.form.currentAmount = 0;
                });
        }
    },
};
</script>
