import { createApp } from "vue";
import App from "@/App.vue";
import router from "@/router/router.js";
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
import { createPinia } from "pinia";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import mixin from "@/mixins/mixin.js";
import permsission_mixin from "@/mixins/permission-mixin.js";
import print_mixin from "@/mixins/print-mixin.js";
import currencyMixin from "@/mixins/currency-mixin.js";
import languageMixin from "@/mixins/language-mixin.js";

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);
app.use(Toast);
app.mixin(mixin);
app.mixin(permsission_mixin);
app.mixin(print_mixin);
app.mixin(currencyMixin);
app.mixin(languageMixin);

app.component("pagination", Bootstrap5Pagination);
app.component("v-select", vSelect);
app.mount("#app");
