<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Language') }} {{ translate('Content') }}
                                {{ translate('Table') }} </h5>
                            <div class="ms-auto align-items-right">
                                <router-link :to="{ name: 'language.list' }" class="btn btn-secondary m-1">
                                    {{ translate('Back') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translate('SL') }}</th>
                                        <th>{{ translate('Key') }}</th>
                                        <th>{{ translate('Value') }}</th>
                                        <th>{{ translate('Update') }}</th>
                                        <th>{{ translate('Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, key, index) in  data " :key="key">
                                        <td>{{ ++index }}</td>
                                        <td><span> {{ key }}</span></td>
                                        <td><input type="text" class="form-control" v-model="data[key]" /></td>
                                        <td>
                                            <button class="form-control" @click="updateLang(key, data[key])"> {{
                                                translate('Update') }} </button>
                                        </td>
                                        <td>
                                            <button class="form-control text-light bg-danger" @click="removeKey(key)">
                                                <span class="material-symbols-outlined google-icon"
                                                    role="button">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
export default {
    data() {
        return {
            toast: useToast(),
            data: {},
            code: this.$route.params.code,
        };
    },

    methods: {
        removeKey(key) {
            let form = { key: key }
            axios
                .put(`/language/translate-key-remove/${this.code}`, form)
                .then((response) => {
                    this.toast.success(response.data);
                })
                .catch((error) => {
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
        updateLang(key, value) {
            this.loader(true)
            let form = { key: key, value: value }
            axios
                .put(`/language/translate-submit/${this.code}`, form)
                .then((response) => {
                    this.loader(false)

                    this.toast.success(response.data);
                })
                .catch((error) => {
                    this.loader(false)
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data);
                    }
                    if (error && error.response.status === 429) {
                        this.toast.error("Too Many Attempts. Try again latter!");
                    }
                    else {
                        this.toast.error(error.response.data);
                    }
                });
        },
        fetchData() {
            axios
                .get(`/language/translate/${this.code}`)
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    },
    created() {
        this.fetchData();
    }

};
</script>
