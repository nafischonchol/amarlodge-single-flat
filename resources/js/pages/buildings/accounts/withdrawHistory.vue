<template>
    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header py-3 bg-transparent">
                <div class="d-sm-flex align-items-center bg-primary">
                    <h6 class="mb-2 mb-sm-0 text-light p-2">{{ translate('History') }} {{ translate('List') }}</h6>
                </div>
                <div class="card-body">
                    <form class="row g-3 mt-1" @change="allErrors.clear($event.target.name)" @submit.prevent="fetchData">
                        <div class="col-lg-3 mb-2">
                            <label class="form-label">{{ translate('Payment') }} {{ translate('Method') }}</label>
                            <select name="bank_type" class="form-control" v-model="form.bank_type">
                                <option value=""> {{ translate('Choose') }}</option>
                                <option value="Cash">Cash</option>
                                <option value="Traditional Bank">Bank</option>
                                <option value="Mobile Bank">Mobile Bank</option>
                            </select>
                            <span v-if="this.allErrors.has('bank_type')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('bank_type')">
                            </span>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">{{ translate('From Date') }}</label>
                            <input name="fdate" class="form-control" type="date" v-model="form.fdate" />
                            <span v-if="this.allErrors.has('fdate')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('fdate')">
                            </span>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">{{ translate('To Date') }}</label>
                            <input name="tdate" class="form-control" type="date" v-model="form.tdate" />
                            <span v-if="this.allErrors.has('tdate')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('tdate')">
                            </span>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <br>
                            <button class="form-control btn border" type="submit">{{ translate('Submit') }} </button>
                        </div>
                    </form>
                    <div class="table-responsive mt-4">
                        <table class="table align-middle table-striped text-center">
                            <thead>
                                <tr>
                                    <th>{{ translate('SL') }}</th>
                                    <th>{{ translate('Date') }}</th>
                                    <th>{{ translate('Withdraw') }} {{ translate('From') }}</th>
                                    <th>{{ translate('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in data" :key="item.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ formatDate(item.created_at) }}</td>
                                    <td>{{ item.bank_type }}</td>
                                    <td>{{ item.amount }}</td>
                                </tr>
                                <tr v-if="data.length === 0">
                                    <th colspan="4">{{ translate('No data found!') }}</th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>{{ translate('Total') }} {{ translate('Amount') }}= {{ calculateTotalAmount() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
import Errors from "@/errors/errors.js";

export default {
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                bank_type: "",
                fdate: new Date().toISOString().substr(0, 10), // Set current date as default
                tdate: new Date().toISOString().substr(0, 10), // Set current date as default
            },
            data: [],
        };
    },
    methods:
    {
        calculateTotalAmount() {
            return this.data.reduce((total, item) => total + item.amount, 0);
        },
        fetchData() {
            this.loader(true)
            this.data = [];
            axios
                .post("/withdraw-history", this.form)
                .then((response) => {
                    this.loader(false)
                    this.allErrors.allClear();
                    this.data = response.data;
                    if (this.data.length <= 0)
                        this.toast.error("Nothing to show!")
                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        console.log(error.response.data);
                        this.toast.error(error.response.data);
                    }
                });
        }
    }
}
</script>
