<template>
    <aside class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <router-link :to="{ name: 'home' }">
                    <img :src="logo" class="logo-icon" alt="logo" @error="handleImageErrorNoImage($event)" />
                </router-link>
            </div>
            <div>
                <router-link :to="{ name: 'home' }">
                    <h4 class="logo-text">{{ name }}</h4>
                </router-link>
            </div>
            <div class="toggle-icon ms-auto" @click="menuToggle"><span class="material-symbols-outlined">
                    menu
                </span></div>
        </div>
        <!--navigation-->
        <SideBar />
        <!--end navigation-->
    </aside>
</template>

<script>
import SideBar from "@/layouts/sideBar.vue";
import "@/components/assets/aside.css";
import axios from "@/axios-config";
import { companyStore } from "@/stores/company.js";
export default {
    components: { SideBar },
    data() {
        return {
            companyStore: companyStore(),
            logo: "/theme/images/logo-icon.png",
            name: "Flat Mng.",
        }
    },
    computed: {
        companyInfo() {
            return this.companyStore.getCompanyData();
        },
    },
    watch: {
        companyInfo: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.logo = "/" + newVal.image;
                    this.name = newVal.name;
                }
            },
        },
    },
    created() {
        this.setCompanyData()
        this.setCurrencyData();
        this.setDefaultImageData();
    }
}
</script>

