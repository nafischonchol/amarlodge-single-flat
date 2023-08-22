export default {
    methods: {
        hasPermission(permissions, permissionKey) {
            // const permissions = localStorage.getItem("permissions");
            if (permissions) {
                return permissions.includes(permissionKey);
            }
            return false;
        },
    },
};
