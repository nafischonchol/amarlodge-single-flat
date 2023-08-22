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
                    <img :src="newImage ? newImage : noImage()" class="img-preview"
                        @error="handleImageErrorNoImage($event)">
                </div>
            </section>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6">
        <div class="image-flex justify-content-between">
            <section>
                <label class="form-label"> {{ translate('Extra') }} {{ translate('Images') }}</label>
                <input name="images" type="file" class="form-control" ref="fileInput" @change="onFilesChangeMultiple"
                    multiple />
                <span v-if="this.allErrors.has('images')" class="error text-danger text-bold ms-2 mt-2"
                    v-text="this.allErrors.get('images')">
                </span>
            </section>
            <section class="mt-1 extra-image-section">
                <div class="image-container">
                    <div class="d-flex">
                        <span v-for="(image, index) in newImages" :key="index">
                            <div class="position-relative">
                                <img :src="image" class="img-preview" @error="handleImageErrorNoImage($event)">
                                <div v-if="this.form.images" class="image-overlay" @click="removeImage(index)">
                                    <span class="remove-icon text-danger">X</span>
                                </div>
                            </div>
                        </span>
                    </div>
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
        images: String,
        title: String,
        isRequired: Boolean,
    },
    data() {
        return {
            newImage: null,
            newImages: null
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
        },


        onFilesChangeMultiple(event) {
            let files = event.target.files;
            this.form.images = [];
            this.newImages = [];
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.images.push(event.target.result);
                    this.newImages.push(event.target.result);
                };
                reader.readAsDataURL(file);
            }
        },
        removeImage(index) {
            this.form.images.splice(index, 1);
            this.newImages.splice(index, 1);
        },
    },
    watch: {
        image: {
            immediate: true, // Run the watcher immediately when the component is mounted
            handler(newVal) {
                if (newVal == '/null')
                    this.newImage = null;
                else
                    this.newImage = newVal;
            }
        },
        images: {
            immediate: true, // Run the watcher immediately when the component is mounted
            handler(newVal) {
                if (newVal !== null)
                    this.newImages = newVal.map(imagePath => `/${imagePath}`);
            }
        }
    },
};
</script>

