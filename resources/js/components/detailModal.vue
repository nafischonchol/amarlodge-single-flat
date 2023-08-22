<template>
    <div aria-labelledby="modalLabel" id="detailsModal" aria-hidden="true" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-light">
                    <h5 class="modal-title">{{ translate(modalTitle) }}</h5>
                    <button aria-label="Close" class="btn-close " data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body details-body">
                    <div class="image-div bg-main  text-light text-center p-4 mb-4" v-if="image && image != '/null'">
                        <img class="rounded-circle image" :src="image" @error="handleImageErrorNoImage($event)" />
                        <h6 v-if="name" class="mt-2">{{ name }}</h6>
                    </div>
                    <div class="details p-3">
                        <h4>
                            <u>{{ translate('Details') }} {{ translate('Information') }}</u>
                        </h4>
                        <template v-for="(value, key) in data" :key="key">
                            <div class="pt-1">
                                <span class="fw-bold">{{ translate(customFormatKey(key)) }}: </span>
                                <span class="fst-italic">{{ value }}</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "@/components/assets/detailsModal.css";
export default {
    props: {
        modalTitle: {
            type: String,
            required: true
        },
        data: {
            type: Object,
            required: false
        },
        image: {
            type: String,
            required: false
        },
        name: {
            type: String,
            required: false
        }
    },
    methods: {
        capitalize(text) {
            return text.charAt(0).toUpperCase() + text.slice(1);
        },
        customFormatKey(key) {
            // console.log(key)
            if (key.includes("_")) {
                const parts = key.split("_").map((part) => this.capitalize(part));
                return parts.join(" ");
            }
            return this.capitalize(key);
        },
    }
};
</script>

