<template>
    <ul class="metismenu" id="menu">
        <li @click="toggleSubmenu('home')">
            <router-link :to="{ name: 'home' }">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        home
                    </span></div>
                <div class="menu-title"> {{ translate('Dashboard') }}</div>
            </router-link>
        </li>
        <li v-show="hasPermission(permissions, 'RBAC')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('RBAC')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        badge
                    </span></div>
                <div class="menu-title"> {{ translate('RBAC') }}</div>
            </a>
            <ul v-if="menuList.RBAC" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'role.list')">
                    <router-link :to="{ name: 'role.list' }">
                        <span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Role') }}
                        </span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'user.list')">
                    <router-link :to="{ name: 'user.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Users') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'user.add')">
                    <router-link :to="{ name: 'user.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Users') }} {{ translate('Add') }}
                        </span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'staff')">
            <a href="javascript:;" class="has-arrow" @click="toggleSubmenu('staff')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        person_apron
                    </span></div>
                <div class="menu-title"> {{ translate('Staff') }}</div>
            </a>
            <ul v-if="menuList.staff" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'staff.list')">
                    <router-link :to="{ name: 'staff.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Staff') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'staff.add')">
                    <router-link :to="{ name: 'staff.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Staff') }} {{ translate('Add') }}</span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'building')">
            <a href="javascript:;" class="has-arrow" @click="toggleSubmenu('building')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        house_siding
                    </span></div>
                <div class="menu-title"> {{ translate('Building') }}</div>
            </a>
            <ul v-if="menuList.building" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'building.add')">
                    <router-link :to="{ name: 'building.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }} {{ translate('Building') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'building.list')">
                    <router-link :to="{ name: 'building.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Building') }} {{ translate('List') }}</span></router-link>
                </li>
            </ul>
        </li>

        <li v-show="hasPermission(permissions, 'building.accounts')">
            <a href="javascript:;" class="has-arrow" @click="toggleSubmenu('building_accounts')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        account_balance
                    </span></div>
                <div class="menu-title"> {{ translate('Accounts') }}</div>
            </a>
            <ul v-if="menuList.building_accounts" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'building.accounts.summary')">
                    <router-link :to="{ name: 'building.accounts.summary' }"><span
                            class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Summary') }}
                        </span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'building.payments.list')">
                    <router-link :to="{ name: 'building.payments.list' }"><span
                            class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Payments') }}
                            {{ translate('List') }}</span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'rent')">
            <a href="javascript:;" class="has-arrow" @click="toggleSubmenu('rent')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        payments
                    </span></div>
                <div class="menu-title"> {{ translate('Rent') }}</div>
            </a>
            <ul v-if="menuList.rent" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'rent.list')">
                    <router-link :to="{ name: 'rent.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'rent.add')">
                    <router-link :to="{ name: 'rent.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }}</span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'flat')">
            <a href="javascript:;" class="has-arrow" @click="toggleSubmenu('flat')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        apartment
                    </span></div>
                <div class="menu-title"> {{ translate('Flats') }}</div>
            </a>
            <ul v-if="menuList.flat" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'flat.list')">

                    <router-link :to="{ name: 'flat.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Flat') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'flat.upcoming.available')">
                    <router-link :to="{ name: 'flat.upcoming.available' }"><span
                            class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Upcoming Available') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'flat.add')">
                    <router-link :to="{ name: 'flat.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }} {{ translate('Flat') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'flat.cost.list')">
                    <router-link :to="{ name: 'flat.cost.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Cost') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'flats.bill.list')">
                    <router-link :to="{ name: 'flats.bill.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Due Bills') }}
                        </span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'flats.bill.pay.history')">
                    <router-link :to="{ name: 'flats.bill.pay.history' }"><span
                            class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Bill Pay History') }}
                        </span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'flat.accounts.index')">
                    <router-link :to="{ name: 'flat.accounts.index' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Accounts') }}</span></router-link>
                </li>
            </ul>
        </li>


        <li v-show="hasPermission(permissions, 'tenant')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('tenant')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        group
                    </span></div>
                <div class="menu-title"> {{ translate('Tenant') }}</div>
            </a>
            <ul v-if="menuList.tenant" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'tenant.list')">
                    <router-link :to="{ name: 'tenant.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Tenant') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'tenant.add')">
                    <router-link :to="{ name: 'tenant.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }} {{ translate('Tenant') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'tenant.move.out.list')">
                    <router-link :to="{ name: 'tenant.move.out.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Move Out') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'tenant.information.list')">
                    <router-link :to="{ name: 'tenant.information.list' }"><span
                            class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Tenant Information') }}
                        </span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'move.out.request')" @click="toggleSubmenu('move_out_request')">
            <router-link :to="{ name: 'move.out.request' }">
                <div class="parent-icon">
                    <span class="material-symbols-outlined">
                        move_up
                    </span>
                </div>
                <div class="menu-title"> {{ translate('Move Out') }} {{ translate('Request') }}</div>
            </router-link>
        </li>

        <li v-show="hasPermission(permissions, 'visitor')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('visitor')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        nest_doorbell_visitor
                    </span></div>
                <div class="menu-title"> {{ translate('Visitor') }}</div>
            </a>
            <ul v-if="menuList.visitor" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'visitor.list')">
                    <router-link :to="{ name: 'visitor.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Visitor') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'visitor.add')">
                    <router-link :to="{ name: 'visitor.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }} {{ translate('Visitor') }}</span></router-link>
                </li>
            </ul>
        </li>

        <li v-show="hasPermission(permissions, 'notice')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('notice')">
                <div class="parent-icon">
                    <span class="material-symbols-outlined">
                        campaign
                    </span>
                </div>
                <div class="menu-title"> {{ translate('Notice') }}</div>
            </a>
            <ul v-if="menuList.notice" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'notice.list')">
                    <router-link :to="{ name: 'notice.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Notice') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'notice.add')">
                    <router-link :to="{ name: 'notice.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }} {{ translate('Notice') }}</span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'complain')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('complain')">
                <div class="parent-icon">
                    <span class="material-symbols-outlined">
                        forum
                    </span>
                </div>
                <div class="menu-title"> {{ translate('Complain') }}</div>
            </a>
            <ul v-if="menuList.complain" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'complain.list')">
                    <router-link :to="{ name: 'complain.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Complain') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'complain.add')">
                    <router-link :to="{ name: 'complain.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }} {{ translate('Complain') }}</span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'committe')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('committe')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        badge
                    </span></div>
                <div class="menu-title"> {{ translate('Management Committe') }}</div>
            </a>
            <ul v-if="menuList.committe" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'committe.list')">
                    <router-link :to="{ name: 'committe.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Member') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'committe.add')">
                    <router-link :to="{ name: 'committe.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }} {{ translate('Member') }}</span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'meeting')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('meeting')">
                <div class="parent-icon"><span class="material-symbols-outlined">
                        sensor_occupied
                    </span></div>
                <div class="menu-title"> {{ translate('Meeting') }}</div>
            </a>
            <ul v-if="menuList.meeting" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'meeting.list')">
                    <router-link :to="{ name: 'meeting.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Meeting') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'meeting.add')">
                    <router-link :to="{ name: 'meeting.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Add') }} {{ translate('Meeting') }}</span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'maintenance-cost')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('maintenance_cost')">
                <div class="parent-icon">
                    <span data-v-bd049706="" class="material-symbols-outlined"> construction </span>
                </div>
                <div class="menu-title"> {{ translate('Maintenance Cost') }} </div>
            </a>
            <ul v-if="menuList.maintenance_cost" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'maintenance.list')">
                    <router-link :to="{ name: 'maintenance.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Cost') }} {{ translate('List') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'maintenance.add')">
                    <router-link :to="{ name: 'maintenance.add' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text">{{ translate('Add') }} {{ translate('Cost') }}</span></router-link>
                </li>
            </ul>
        </li>
        <li v-show="hasPermission(permissions, 'setting.utility.setup.list')"
            @click="toggleSubmenu('setting_utility_setup_list')">
            <router-link :to="{ name: 'setting.utility.setup.list' }">
                <div class="parent-icon">
                    <span class="material-symbols-outlined">
                        savings
                    </span>
                </div>
                <div class="menu-title"> {{ translate('Utility Bill Setup') }}</div>
            </router-link>
        </li>
        <li v-show="hasPermission(permissions, 'setting')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('setting')">
                <div class="parent-icon">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                </div>
                <div class="menu-title"> {{ translate('Setting') }}</div>
            </a>
            <ul v-if="menuList.setting" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'setting.general')">
                    <router-link :to="{ name: 'setting.general' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('General') }} {{ translate('Setting') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'setting.bank.setup')">
                    <router-link :to="{ name: 'setting.bank.setup' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Bank') }} {{ translate('Setup') }}
                        </span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'activity.log.list')">
                    <router-link :to="{ name: 'activity.log.list' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Activity Log') }} </span></router-link>
                </li>
            </ul>
        </li>

        <li v-show="hasPermission(permissions, 'report')">
            <a class="has-arrow" href="javascript:;" @click="toggleSubmenu('report')">
                <span class="material-symbols-outlined">
                    monitoring
                </span>
                <div class="menu-title"> {{ translate('Report') }}</div>
            </a>
            <ul v-if="menuList.report" @click="menuToggle">
                <li v-show="hasPermission(permissions, 'report.rental.filter')">
                    <router-link :to="{ name: 'report.rental.filter' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Rental') }} {{ translate('Report') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'report.mc.filter')">
                    <router-link :to="{ name: 'report.mc.filter' }"><span class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Maintenance') }} {{ translate('Report')
                        }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'report.visitor.filter')">
                    <router-link :to="{ name: 'report.visitor.filter' }"><span
                            class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Visitor') }} {{ translate('Report') }}</span></router-link>
                </li>
                <li v-show="hasPermission(permissions, 'report.complain.filter')">
                    <router-link :to="{ name: 'report.complain.filter' }"><span
                            class="material-symbols-outlined small-icon ">
                            radio_button_unchecked
                        </span>
                        <span class="icon-text"> {{ translate('Complain') }} {{ translate('Report') }}</span></router-link>
                </li>
            </ul>
        </li>

        <li @click="menuToggle" v-show="hasPermission(permissions, 'language.list')">
            <router-link :to="{ name: 'language.list' }">
                <div class="parent-icon">
                    <span class="material-symbols-outlined">
                        g_translate
                    </span>
                </div>
                <div class="menu-title"> {{ translate('Language') }}</div>
            </router-link>
        </li>
    </ul>
</template>

<script>
import axios from "@/axios-config";
import "@/components/assets/sidebar.css";

export default {
    data() {
        return {
            permissions: [],
            menuList: {
                home: false,
                RBAC: false,
                building: false,
                building_accounts: false,
                rent: false,
                flat: false,
                flat_bill: false,
                tenant: false,
                move_out_request: false,
                visitor: false,
                staff: false,
                notice: false,
                complain: false,
                committe: false,
                meeting: false,
                maintenance_cost: false,
                setting_utility_setup_list: false,
                setting: false,
                report: false,
                language_list: false,
            },
            routesToCloseSubmenus: ['user.profile', 'home', 'notification.list'],

        }
    },
    methods: {
        toggleSubmenu(menuName) {
            for (const menu in this.menuList) {
                if (menu !== menuName) {
                    this.menuList[menu] = false;
                }
            }
            this.menuList[menuName] = !this.menuList[menuName];
        },
        getPermissions() {
            return axios
                .get('/rbac/users-permissions')
                .then((response) => {
                    this.permissions = response.data;
                    localStorage.setItem("permissions", response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    created() {
        this.getPermissions();
    },
    watch: {
        $route(to, from) {
            if (this.routesToCloseSubmenus.includes(to.name)) {
                for (const menu in this.menuList) {
                    this.menuList[menu] = false;
                }
            }
        }
    }
}
</script>

