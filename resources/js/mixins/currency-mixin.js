import axios from "@/axios-config";
import { companyStore } from "@/stores/company.js";
export default {
    data() {
        return {
            companyStore: companyStore(),
            currency_symbol: "$",
        };
    },
    methods: {
        handleImageErrorNoImage(event) {
            let image = this.companyStore.getDefaultImageData();
            event.target.src = image;
        },
        noImage() {
            let image = this.companyStore.getDefaultImageData();
            return image;
        },
        handleImageErrorAvatar(event) {
            event.target.src = "/images/avatar-1.png";
        },
        setDefaultImageData() {
            axios
                .get(`/general-settings/default-image`)
                .then((response) => {
                    let image = response.data;
                    if (image && Object.keys(image).length > 0) {
                        this.companyStore.setDefaultImage("/" + image);
                    } else {
                        this.companyStore.setDefaultImage(
                            "/images/noimage.jpg"
                        );
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        setCompanyData() {
            axios
                .get(`/company-info`)
                .then((response) => {
                    this.companyStore.setCompany(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        setCurrencyData() {
            axios
                .get("/general-settings/currency")
                .then((response) => {
                    let data = response.data;
                    if (data && Object.keys(data).length > 0) {
                        this.companyStore.setCurrency(data);
                    } else {
                        let defaultCurrency = {
                            currency_name: "BDT",
                            currency_symbol: "৳",
                        };
                        this.companyStore.setCurrency(defaultCurrency);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        currencyInfo() {
            // const currency = JSON.parse(localStorage.getItem("currency"));
            const currency = this.companyStore.getCurrenyData();
            this.currency_symbol = currency?.currency_symbol ?? "$";
        },
    },
    mounted() {
        this.currencyInfo();
    },
};
