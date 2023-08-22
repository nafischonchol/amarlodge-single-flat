<template>
    <div class="col-md-6 col-sm-6 col-lg-6">
        <label class="form-label">{{ translate('Nid') }} {{ translate('Image') }}</label>
        <input name="image" type="file" class="form-control" ref="fileInput" @change="onFileChange" />
        <span v-if="this.allErrors.has('image')" class="error text-danger text-bold ms-2 mt-2"
            v-text="this.allErrors.get('image')">
        </span>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-sm-6 col-lg-6">
            <div class="image-container">
                <img :src="newImage ? newImage : noImage()" class="img-preview" @error="handleImageErrorNoImage($event)">
            </div>
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
                this.form.nid_image = event.target.result;
                this.newImage = this.form.nid_image;
                console.log(this.newImage)
                console.log("hello")

            };
            reader.readAsDataURL(file);
        }
    },
    watch: {
        image: {
            immediate: true, // Run the watcher immediately when the component is mounted
            handler(newVal) {
                this.newImage = newVal;
                if (this.newImage == "/null") {
                    this.newImage = null;
                }
            }
        }
    },
};
</script>

