<template>
    <header class="top-header">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-icon fs-3" @click="menuToggle">
                <span class="material-symbols-outlined">
                    menu
                </span>
            </div>
            <div class="top-navbar-right ms-auto">
                <ul class="navbar-nav align-items-center">
                    <Language />
                    <Notification />

                    <li class="nav-item dropdown dropdown-user-setting">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                            <div class="user-setting d-flex align-items-center">
                                <img :src="user_details.image ? '/' + user_details.image : default_image" class="user-img"
                                    @error="handleImageErrorAvatar($event)" />
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <router-link class="dropdown-item" :to="{ name: 'user.profile' }">
                                    <div class="d-flex align-items-center">
                                        <img :src="user_details.image ? '/' + user_details.image : default_image"
                                            class=" rounded-circle" width="54" height="54"
                                            @error="handleImageErrorAvatar($event)" />
                                        <div class="ms-3">
                                            <h6 class="mb-0 dropdown-user-name">{{ user_details.name }}</h6>
                                        </div>
                                    </div>
                                </router-link>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <router-link class="dropdown-item" :to="{ name: 'user.profile' }">
                                    <div class="d-flex align-items-center">
                                        <div class=""><span class="material-symbols-outlined">
                                                person
                                            </span></div>
                                        <div class="ms-3"><span>{{ translate('Profile') }}</span></div>
                                    </div>
                                </router-link>
                            </li>

                            <li>
                                <router-link class="dropdown-item" :to="{ name: 'home' }">
                                    <div class="d-flex align-items-center">
                                        <div class=""><span class="material-symbols-outlined">
                                                dashboard
                                            </span></div>
                                        <div class="ms-3"><span>{{ translate('Dashboard') }}</span></div>
                                    </div>
                                </router-link>
                            </li>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <div class="dropdown-item cursor-pointer" @click="logout">
                                    <div class="d-flex align-items-center">
                                        <div class=""><span class="material-symbols-outlined">
                                                lock_open
                                            </span></div>
                                        <div class="ms-3"><span>{{ translate('Logout') }}</span></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
import Notification from "@/layouts/notification.vue";
import Language from "@/layouts/language.vue";

import { userStore } from "@/stores/user.js";
export default {
    components: { Notification, Language },
    data() {
        return {
            auth: userStore(),
            default_image: "/images/avatar-1.png",
            user_details: []
        }
    },
    computed: {
        userInfo() {
            return this.auth.getUserData();
        },
    },
    methods:
    {
        logout() {
            localStorage.clear();
            this.auth.setUserNull();
            this.$router.push({ name: 'login' });
        },
        updateUserHeaderMethod() {
            const user = this.auth.getUserData();
            if (user) {
                this.user_details = user;
            }
        }
    },
    watch: {
        userInfo: {
            immediate: true,
            handler(newUserInfo) {
                if (newUserInfo) {
                    this.updateUserHeaderMethod();
                }
            },
        },
    },
}
</script>

