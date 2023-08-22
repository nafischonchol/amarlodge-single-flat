<template>
    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ translate("Edit") }} {{ translate("Bank") }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="editBank">
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label">{{ translate("Bank") }} {{ translate('Name') }}</label><span
                                class="text-danger">*</span>
                            <input name="bank_name" class="form-control" v-model="form.bank_name" />
                            <span v-if="this.allErrors.has('bank_name')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('bank_name')">
                            </span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                            <label class="form-label">{{ translate("Bank") }} {{ translate("Type") }}</label><span
                                class="text-danger">*</span>
                            <select name="bank_type" class="form-control" v-model="form.bank_type">
                                <option value="">{{ translate('Choose') }}</option>
                                <option value="Mobile Bank">{{ translate('Mobile Bank') }}</option>
                                <option value="Traditional Bank">{{ translate('Traditional Bank') }}</option>
                            </select>
                            <span v-if="this.allErrors.has('bank_type')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('bank_type')">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('Cancel')
                        }}</button>
                        <button class="btn btn-primary" type="submit"> {{ translate('Submit') }} </button>
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
        bankData: Object
    },
    data() {
        return {
            allErrors: new Errors(),
            toast: null,
            form: {},
        };
    },
    methods:
    {
        editBank() {
            this.loader(true)
            axios
                .put(`/setting/bank-setup/${this.form.id}`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.form.bank_name = "";
                    $("#edit-modal").modal("hide");
                    this.$emit("afterSubmit");
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
    watch: {
        bankData: {
            immediate: true,
            handler(newVal) {
                this.form = { ...newVal }; // Create a new object to preserve reactivity
                this.allErrors.allClear();
            }
        }
    },
    created() {
        this.toast = useToast(); // Assign the value of 'toast'
    },
}
</script>
