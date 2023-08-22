<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0 align-items-left">{{ RoleInfo.name }}</h5>
                        </div>
                    </div>
                    <div class="card-body overflow-y-auto">
                        <table class="table ">
                            <thead>
                                <tr class="bg-green">
                                    <th> {{ translate('Module') }} {{ translate('Permission') }}
                                    </th>
                                    <th> {{ translate('Feature') }} {{ translate('Permission') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="permission_data in PermissionList" :key="permission_data.name">
                                    <td v-if="permission_data.description === 'MODULE'">
                                        <table class="table text-center">
                                            <tbody>
                                                <tr class="text-light bg-gray">
                                                    <th>{{ translate('Module') }}</th>
                                                    <th>{{ translate('Permission') }}</th>
                                                </tr>
                                                <tr class="text-secondary">
                                                    <td>{{ permission_data.display_name }}</td>
                                                    <td><input type="checkbox"
                                                            :checked="PermittedPermission.includes(permission_data.id)"
                                                            @click="AccessPermit(permission_data.id)" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td v-if="permission_data.description === 'MODULE'">
                                        <table class="table text-center">
                                            <tbody>
                                                <tr class="bg-gray text-light">
                                                    <th>{{ translate('Feature') }}</th>
                                                    <th>{{ translate('Permission') }}</th>
                                                </tr>
                                                <tr class="text-secondary" v-for="(feature_data, index) in PermissionList"
                                                    :key="index">
                                                    <td
                                                        v-if="permission_data.display_name === feature_data.module && feature_data.description === 'FEATURE'">
                                                        {{ feature_data.display_name }}
                                                    </td>
                                                    <td
                                                        v-if="permission_data.display_name === feature_data.module && feature_data.description === 'FEATURE'">
                                                        <input type="checkbox"
                                                            :checked="PermittedPermission.includes(feature_data.id)"
                                                            @click="AccessPermit(feature_data.id)" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>
</template>

<script>
import axios from "@/axios-config";
import { useToast } from "vue-toastification";
export default {
    data() {
        return {
            toast: useToast(),
            RoleInfo: {},
            PermissionList: {},
            PermittedPermission: {},
            role_id: this.$route.params.id,
        };
    },
    methods: {
        fetchData() {
            console.log(this.role_id);
            axios
                .get(`/rbac/roles-permissions/${this.role_id}`)
                .then((response) => {
                    this.RoleInfo = response.data.role_info;
                    this.PermissionList = response.data.all_permission;
                    this.PermittedPermission = response.data.permitted_permission;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        AccessPermit(permission) {
            this.loader(true)
            let permissionForm = {
                role_id: this.role_id,
                permission_id: permission,
            };
            axios
                .post('/rbac/roles-permissions', permissionForm)
                .then((response) => {
                    this.loader(false)
                    if (response.status === 201) {
                        this.toast.success("Permission granted", "Success");
                    } else {
                        this.toast.warning("Permission revoked", "Success");
                    }
                })
                .catch((error) => {
                    this.loader(false)
                    toastr.error("Application error", "Success");
                });
        }
    },
    mounted() {
        this.fetchData();
    },
}
</script>


