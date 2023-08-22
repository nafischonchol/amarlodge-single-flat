import { defineStore } from "pinia";

export const companyStore = defineStore("companyPinia", {
    state: () => {
        return {
            company: null,
            currency: null,
            defaultImage: null,
        };
    },
    getters: {},
    actions: {
        setCompanyNull() {
            this.currency = null;
            this.company = null;
        },
        setCompany(data) {
            this.company = data;
            localStorage.setItem("company", JSON.stringify(data));
        },
        setCurrency(data) {
            this.currency = data;
            localStorage.setItem("currency", JSON.stringify(data));
        },
        setDefaultImage(data) {
            this.defaultImage = data;
            localStorage.setItem("defaultImage", JSON.stringify(data));
        },
        getCompanyData() {
            return this.company;
        },
        getCurrenyData() {
            return this.currency;
        },
        getDefaultImageData() {
            return this.defaultImage;
        },
        getFromLocalStorage() {
            const companyData = localStorage.getItem("company");
            const currencyData = localStorage.getItem("currency");
            const defaultImageData = localStorage.getItem("defaultImage");

            if (companyData) {
                this.company = JSON.parse(companyData);
            }
            if (currencyData) {
                this.currency = JSON.parse(currencyData);
            }
            if (defaultImageData) {
                this.defaultImage = JSON.parse(defaultImageData);
            }
        },
    },
});
