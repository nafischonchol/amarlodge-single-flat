<template>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
            <div>
                <img width="25" :src="getFlagImageUrl">
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end p-0  m-1">
            <div v-for="    item     in     data    " :key="item">
                <div class="dropdown-item" role="button" @click="setCurrentLanguage(item.code)">
                    <img class="margin-right-6" width="20" :src="'/flags/' + item.code + '.png'" :alt="item.name" />
                    <span class="text-capitalize">{{ item.name }}</span>
                </div>
            </div>
        </div>
    </li>
</template>
<script>
import axios from "@/axios-config";
import { userStore } from "@/stores/user.js";
import { languageStore } from "@/stores/language.js";

export default {
    data() {
        return {
            auth: userStore(),
            language: languageStore(),
            data: {},
        }
    },
    computed: {
        getFlagImageUrl() {
            return '/flags/' + this.language.getCurrentLanguage() + '.png';
        }
    },
    methods: {
        setCurrentLanguage(code) {
            this.language.setCurrent(code);
            this.loadTranslations();
        },
        fetchData() {
            axios
                .get('/language/active-list')
                .then((response) => {
                    this.data = response.data;
                    if (this.data) {
                        this.language.setDefault(this.data[0].code);
                        const currentLanguageHasBeenSet = localStorage.getItem('currentLanguageHasBeenSet');

                        if (!currentLanguageHasBeenSet) {
                            this.language.setCurrent(this.data[0].code);
                            this.loadTranslations();
                            localStorage.setItem('currentLanguageHasBeenSet', 'true');
                        }
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        loadTranslations() {
            const token = this.auth.getToken;
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
            let code = this.language.getCurrentLanguage();
            axios
                .get(`/language/translations/${code}`)
                .then((response) => {
                    let data = response.data;
                    if (data)
                        this.language.setTranslations(data);
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    },
    created() {
        this.loadTranslations();
        this.fetchData();
    }
}
</script>
