
<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ translate('Tenant') }} {{ translate('Information')
                            }}</h5>
                            <div class="ms-auto">
                                <router-link :to="{ name: 'tenant.information.list' }" class="btn btn-secondary m-1">
                                    {{ translate('Tenant') }} {{ translate('List') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12 col-md-12 col-sm-12">
                                <div class="card shadow-none bg-light border">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                <img :src="'/' + form.image" alt="Item Image" class="passport-size-image"
                                                    @error="handleImageErrorNoImage($event)">
                                            </div>
                                            <div class="col-4 item-center">
                                                <h5>ঢাকা মেট্রোপলিটন পুলিশ</h5>
                                                <p><strong>বিভাগ :</strong> ................................</p>
                                                <p><strong>থানা :</strong> ....................................</p>
                                                <p>ভাড়াটে নিবন্ধন ফরম</p>
                                            </div>
                                            <div class="col-4">

                                            </div>
                                        </div>
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
import "@/components/assets/images.css";

export default {
    data() {
        return {
            allErrors: new Errors(),
            toast: useToast(),
            form: {},
            route_id: this.$route.params.id,
        };
    },
    methods:
    {
        fetchData() {
            axios
                .get(`/tenant-informations/${this.route_id}`)
                .then((response) => {
                    this.form = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    mounted() {
        this.fetchData();
    }
};
</script>
