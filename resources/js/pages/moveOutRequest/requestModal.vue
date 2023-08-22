<template>
    <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ translate('Move Out') }} {{ translate('Request') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">
                    <div class="modal-body">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label">{{ translate('Move Out') }} {{ translate('Date') }}</label>
                            <input name="move_out_date" type="date" class="form-control" v-model="form.move_out_date" />
                            <span v-if="this.allErrors.has('move_out_date')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('move_out_date')">
                            </span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                            <label class="form-label">{{ translate('Reason') }}</label>
                            <textarea name="reasone" class="form-control" v-model="form.reason"> </textarea>
                            <span v-if="this.allErrors.has('reasone')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('reasone')">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                            {{ translate('Submit') }}</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ translate('Close') }}
                        </button>
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
    props: {
        callBackMethod: {
            type: Function,
            required: true,
        },
    },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
                move_out_date: this.currentDate(),
                reason: "",
            },
        }
    },
    methods: {
        submitForm() {
            this.loader(true)
            axios
                .post("/move-out-request", this.form)
                .then((response) => {
                    this.loader(false)
                    this.callBackMethod();
                    $("#requestModal").modal("hide");
                    this.toast.success(response.data);
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
    },
};
</script>
