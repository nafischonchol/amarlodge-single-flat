<template>
    <div class="col-md-6 col-sm-6 col-lg-6">
        <div class="image-flex justify-content-between">
            <section>
                <label class="form-label">{{ this.title == null ? translate('Image') : translate(this.title) }}</label>
                <span class="text-danger" v-if="isRequired">*</span>
                <input name="image" type="file" class="form-control" ref="fileInput" @change="onFileChange" />
                <span v-if="this.allErrors.has('image')" class="error text-danger text-bold ms-2 mt-2"
                    v-text="this.allErrors.get('image')">
                </span>
            </section>
            <section class="mt-1">
                <div class="image-container">
                    <img :src="newImage" class="img-preview" @error="handleImageErrorNoImage($event)">
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import "@/components/imagePreview.css";
export default {
    props: {
        form: Object, // Pass the "form" object as a prop
        allErrors: Object, // Pass the "form" object as a p
        image: String,
        title: String,
        isRequired: String,
    },
    data() {
        return {
            newImage: null,
        }
    },
    methods: {
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.form.image = event.target.result;
                this.newImage = this.form.image;
            };
            reader.readAsDataURL(file);
        }
    },
    watch: {
        image: {
            immediate: true, // Run the watcher immediately when the component is mounted
            handler(newVal) {
                if (newVal == '/null' || newVal == null) {
                    this.newImage = this.noImage();
                }
                else
                    this.newImage = newVal;
            }
        }
    },
};
</script>

