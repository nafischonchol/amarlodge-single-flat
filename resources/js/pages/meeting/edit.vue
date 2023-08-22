<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate("Meeting") }} {{ translate('Edit') }}
                            </h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'meeting.list' }" class="btn btn-secondary m-1">
                                    {{ translate('List') }}
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
                                                <label class="form-label"> {{ translate('Title') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="title" type="text" class="form-control" v-model="form.title" />
                                                <span v-if="allErrors.has('title')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('title')"></span>
                                            </div>
                                            <BuildingPicker :form="form" :allErrors="allErrors" />
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label class="form-label"> {{ translate('Date') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input name="date" type="date" class="form-control" v-model="form.date" />
                                                <span v-if="allErrors.has('date')"
                                                    class="error text-danger text-bold ms-2 mt-2"
                                                    v-text="allErrors.get('date')"></span>
                                            </div>
                                            <div class="col-md-12 col-md-12 col-sm-12">
                                                <div>
                                                    <label class="form-label">{{ translate('Details') }}</label> <span
                                                        class="text-danger">*</span>
                                                    <div ref="editor" class="quill-container"></div>
                                                    <span v-if="allErrors.has('description')"
                                                        class="error text-danger text-bold ms-2 mt-2"
                                                        v-text="allErrors.get('description')"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button class="form-control btn btn-primary" type="submit"
                                                    :disabled="isLoading">{{
                                                        translate('Submit') }}</button>
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
import BuildingPicker from "@/components/BuildingPicker.vue";
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

export default {
    components: { BuildingPicker },
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {},
            routeId: this.$route.params.id,
        }
    },
    methods:
    {
        fetchData() {
            axios
                .get(`/meeting/${this.routeId}`)
                .then((response) => {
                    this.form = response.data;
                    this.initializeQuillEditor();
                })
                .catch((error) => {
                    this.toast.error("Something goes wrong!");
                });
        },

        submitForm() {
            this.loader(true)
            axios
                .put(`/meeting/${this.routeId}`, this.form)
                .then((response) => {
                    this.loader(false)
                    this.toast.success(response.data);
                    this.$router.push({ name: 'meeting.list' });
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
        }, //end submit

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

            this.quill.root.innerHTML = this.form.description;

            this.quill.on('text-change', () => {
                this.form.description = this.quill.root.innerHTML;
                this.clearQuillEditor();
            });
        },
        clearQuillEditor() {
            if (this.quill) {
                const isEmpty = this.quill.getLength() === 1 && !this.quill.getText().trim();
                const hasDefaultContent = this.quill.root.innerHTML === '<p><br></p>';

                if (isEmpty || hasDefaultContent) {
                    this.form.description = '';
                }
            }
        },

    }, //end method
    mounted() {
        this.fetchData();
    },
};
</script>

