<template>
    <main class="page-content">
        <template v-if="user_role != 'Tenant'">
            <OwnerDashboard />
        </template>
        <template v-if="user_role == 'Tenant'">
            <TenatDashboard />
        </template>
    </main>
</template>

<script>
import OwnerDashboard from "@/pages/dashboard/owner-dashboard.vue";
import TenatDashboard from "@/pages/dashboard/tenant-dashboard.vue";

export default {
    components: { OwnerDashboard, TenatDashboard },
    data() {
        return {
            user_role: ""
        };
    },
    created() {
        this.user_role = localStorage.getItem("role");
    }
}
</script>
