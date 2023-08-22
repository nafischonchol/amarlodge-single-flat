import { defineStore } from "pinia";

export const languageStore = defineStore("language", {
    state: () => {
        return {
            default_language: "en",
            current_language: "en",
            translations: {},
        };
    },
    actions: {
        setDefault(code) {
            this.default_language = code;
            localStorage.setItem("default_language", code);
        },
        setCurrent(code) {
            this.current_language = code;
            localStorage.setItem("current_language", code);
        },
        setTranslations(newTranslations) {
            this.translations = newTranslations;
            localStorage.setItem(
                "translations",
                JSON.stringify(newTranslations)
            );
        },
        getDefaultLanguage() {
            return this.default_language;
        },
        getCurrentLanguage() {
            return this.current_language;
        },
        getTranslations() {
            return this.translations;
        },
        setFromLocalStorage() {
            const default_languageData =
                localStorage.getItem("default_language");
            const current_languageData =
                localStorage.getItem("current_language");
            const translationsData = localStorage.getItem("translations");
            if (default_languageData) {
                this.default_language = default_languageData;
            }
            if (current_languageData) {
                this.current_language = current_languageData;
            }
            if (translationsData) {
                this.translations = JSON.parse(translationsData);
            }
        },
    },
});
