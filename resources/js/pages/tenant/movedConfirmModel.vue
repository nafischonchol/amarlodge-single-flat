<template>
    <div class="modal fade" id="move-out-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ translate('Confirm') }} {{ translate('Moved') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ translate('Are you sure you want to move out this tenant?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('Cancel')
                    }}</button>
                    <button type="button" class="btn btn-danger" @click="confirm">{{ translate('Confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
export default {
    props: {
        tenant_id: {
            type: Number,
            required: true,
        },
        fetchData: {
            type: Function,
            required: true,
        },
    },
    data() {
        return {
            toast: useToast(),
        }
    },
    methods: {
        confirm() {
            this.loader(true)
            axios
                .put(`/tenant-move-out/${this.tenant_id}`)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.fetchData();
                })
                .catch((error) => {
                    this.loader(false)
                    this.toast.error(error.response.data);
                })
                .finally(() => {
                    $("#move-out-modal").modal("hide");
                });
        },
    },
};
</script>
