
<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Notice') }} {{ translate('Edit') }}</h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'notice.list' }" class="btn btn-secondary m-1">
                                    {{ translate('Notice') }} {{ translate('List') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12 col-md-12 col-sm-12">
                                <div class="card shadow-none bg-light border">
                                    <div class="card-body">
                                        <form class="row g-3" @keydown="allErrors.clear($event.target.name)"
                                            @submit.prevent="submitForm">

                                            <div class="col-md-12 col-md-12 col-sm-12">
                                                <label class="form-label">{{ translate('Notice') }} {{ translate('Title')
                                                }}</label> <span class="text-danger">*</span>
                                                <input name="title" type="text" class="form-control"
                                                    placeholder="Notice Title" v-model="form.title" />
                                                <span v-if="allErrors.has('title')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('title')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Building') }}</label> <span
                                                    class="text-danger">*</span>
                                                <select name="building_id" class="form-control" v-model="form.building_id"
                                                    @change="updateFlat">
                                                    <option selected value="0">All Building</option>
                                                    <option v-for="building in buildingList" :key="building.id"
                                                        :value="building.id">
                                                        {{ building.name }}
                                                    </option>
                                                </select>
                                                <span v-if="allErrors.has('building_id')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('building_id')"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label">{{ translate('Notice') }} {{ translate('Status')
                                                }}</label> <span class="text-danger">*</span>
                                                <select name="status" class="form-control" v-model="form.status">
                                                    <option value="1">Publish Now</option>
                                                    <option value="0">Disable</option>
                                                </select>
                                                <span v-if="allErrors.has('status')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('status')"></span>
                                            </div>
                                            <div class="col-md-12 col-md-12 col-sm-12">
                                                <div>
                                                    <label class="form-label">{{ translate('Notice') }} {{
                                                        translate('Details') }} <span class="text-danger">*</span></label>
                                                    <div ref="editor" class="quill-container"></div>
                                                    <span v-if="allErrors.has('details')"
                                                        class="error text-danger text-bold ms-2 mt-2"
                                                        v-text="allErrors.get('details')"></span>
                                                </div>

                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit"
                                                    :disabled="isLoading">{{ translate('Submit') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--end row-->
</template>

<script>
import axios from "@/axios-config";
import Errors from "@/errors/errors.js";
import { useToast } from "vue-toastification";
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

export default {

    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {
            },
            noticeId: this.$route.params.id,
            buildingList: [],
        };
    },
    methods:
    {
        fetchBuilding() {
            axios
                .get("/buildings/all")
                .then((response) => {
                    this.buildingList = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchData() {
            axios
                .get(`/notices/${this.noticeId}`)
                .then((response) => {
                    this.form = response.data;
                    this.initializeQuillEditor();
                })
                .catch((error) => {
                    console.log("Something goes wrong!");
                });
        },
        submitForm() {
            this.loader(true)
            axios
                .put(`/notices/${this.noticeId}`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'notice.list' });
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

        initializeQuillEditor() {
            this.quill = new Quill(this.$refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['link'],
                    ],
                },
            });

            this.quill.root.innerHTML = this.form.details;

            this.quill.on('text-change', () => {
                this.form.details = this.quill.root.innerHTML;
                this.clearQuillEditor();
            });
        },

        clearQuillEditor() {
            if (this.quill) {
                const isEmpty = this.quill.getLength() === 1 && !this.quill.getText().trim();
                const hasDefaultContent = this.quill.root.innerHTML === '<p><br></p>';

                if (isEmpty || hasDefaultContent) {
                    this.form.details = '';
                }
            }
        },
    },
    mounted() {
        this.fetchBuilding();
        this.fetchData();
    },
};
</script>

