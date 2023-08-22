import { languageStore } from "@/stores/language.js";
export default {
    data() {
        return {
            language: languageStore(),
        };
    },
    methods: {
        translate(key) {
            let translations = this.language.getTranslations();
            if (translations && translations[key]) {
                return translations[key];
            }
            return key;
        },
    },
};
