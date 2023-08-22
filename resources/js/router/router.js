import { createWebHistory, createRouter } from "vue-router";
import routes from "@/router/routes.js";
import { useToast } from "vue-toastification";
import { userStore } from "@/stores/user.js";
import { companyStore } from "@/stores/company.js";
import { languageStore } from "@/stores/language.js";

const router = createRouter({
    history: createWebHistory(),
    routes,
});
const toast = useToast();
const checkPermissions = (to) => {
    const permissions = localStorage.getItem("permissions");
    if (permissions) {
        if (to.name !== "home" && !permissions.includes(to.name)) {
            return false;
        } else {
            return true;
        }
    }
    return false;
};

// Add route guard to check for authentication
router.beforeEach((to, from, next) => {
    const auth = userStore();
    auth.getUserFromLocalStorage();
    const companyPinia = companyStore();
    companyPinia.getFromLocalStorage();
    const languagePinia = languageStore();
    languagePinia.setFromLocalStorage();

    const requiresAuth = !to.meta.guestOnly;
    const permissionCheck = to.meta.permission_check;
    const isAuthenticated = localStorage.getItem("scantumToken");

    if (requiresAuth && !isAuthenticated) {
        next({ path: "/login" });
    } else if (to.path === "/login" && isAuthenticated) {
        next({ path: "/" });
    } else if (requiresAuth && isAuthenticated && permissionCheck !== false) {
        const hasPermission = checkPermissions(to);
        if (!hasPermission) {
            toast.error("You don't have permission");
            return next({ path: "/" });
        } else {
            next();
        }
    } else {
        next();
    }
});

router.afterEach((to) => {
    if (to.meta && to.meta.title) {
        document.title = to.meta.title + " | Flat Management";
    }
});

export default router;
