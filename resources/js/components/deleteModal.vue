<template>
    <div class="modal fade" :id="modalId" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"> {{ translate('Confirm') }} {{ translate('Delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ translate('Are you sure you want to delete this item?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ translate('Cancel')
                    }}</button>
                    <button type="button" class="btn btn-danger" @click="confirmDelete"> {{ translate('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        modalId: {
            type: String,
            required: true,
        },
        onDelete: {
            type: Function,
            required: true,
        },
    },
    methods: {
        confirmDelete() {
            this.onDelete();
            $(`#${this.modalId}`).modal('hide');
        },
    },
};
</script>
