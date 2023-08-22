<template>
    <li class="nav-item dropdown dropdown-large">
        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
            <div class="notifications">
                <span class="notify-badge">{{ unreadTotal }}</span>
                <span class="material-symbols-outlined">
                    notifications
                </span>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end p-0">
            <div class="p-2 border-bottom m-2">
                <h5 class="h5 mb-0">{{ translate('Notifications') }}</h5>
            </div>
            <div class="header-notifications-list p-2">
                <template v-if="unreadList.length <= 0">
                    <a class="dropdown-item" href="#">
                        <div class="d-flex align-items-center">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 dropdown-msg-user">{{ translate("You don't have notifications") }} </h6>
                            </div>
                        </div>
                    </a>
                </template>
                <template v-else>
                    <div v-for="(item, index) in unreadList" :key="index">
                        <a class="dropdown-item" href="#">
                            <div class="d-flex align-items-center">
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="mb-0 dropdown-msg-user">{{ item.notification_type }}
                                        <span class="msg-time float-end text-secondary">{{ getTimeAgo(item.created_at)
                                        }}</span>
                                    </h6>
                                    <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">{{
                                        item.details }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
            <div class="p-2">
                <div>
                    <hr class="dropdown-divider">
                </div>
                <router-link class="dropdown-item" :to="{ name: 'notification.list' }">
                    <div class="text-center">{{ translate('View All Notifications') }}</div>
                </router-link>
            </div>
        </div>
    </li>
</template>

<script>
import axios from "@/axios-config";
export default {
    data() {
        return {
            unreadList: [],
            unreadTotal: 0
        }
    },
    methods: {
        fetchUnread() {
            axios
                .get('/notifications/unread')
                .then((response) => {
                    let data = response.data;
                    this.unreadTotal = data.total;
                    this.unreadList = data.list;
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    },
    created() {
        this.fetchUnread();
    }
}
</script>
