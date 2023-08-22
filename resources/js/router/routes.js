import main from "@/layouts/main.vue";
import guestLayout from "@/layouts/guestLayout.vue";
import home from "@/pages/dashboard/index.vue";
import login from "@/pages/login.vue";
import register from "@/pages/register.vue";
import createStaff from "@/pages/staff/create.vue";
import staffList from "@/pages/staff/index.vue";
import staffEdit from "@/pages/staff/edit.vue";
import createBuilding from "@/pages/buildings/create.vue";
import buildingList from "@/pages/buildings/index.vue";
import buildingEdit from "@/pages/buildings/edit.vue";
import createFlat from "@/pages/flats/create.vue";
import flatList from "@/pages/flats/index.vue";
import flatUpcomingAvailable from "@/pages/flats/up-comming-available.vue";
import flatEdit from "@/pages/flats/edit.vue";
import createVisitor from "@/pages/visitors/create.vue";
import visitorList from "@/pages/visitors/index.vue";
import visitorEdit from "@/pages/visitors/edit.vue";
import createRole from "@/pages/rbac/role/create.vue";
import roleList from "@/pages/rbac/role/index.vue";
import roleEdit from "@/pages/rbac/role/edit.vue";
import createUser from "@/pages/rbac/user/create.vue";
import userList from "@/pages/rbac/user/index.vue";
import editRolePermission from "@/pages/rbac/rolePermission/edit.vue";
import createTenant from "@/pages/tenant/create.vue";
import tenantList from "@/pages/tenant/index.vue";
import tenantEdit from "@/pages/tenant/edit.vue";
import createNotice from "@/pages/notice/create.vue";
import noticeList from "@/pages/notice/index.vue";
import noticeEdit from "@/pages/notice/edit.vue";
import complainCreate from "@/pages/complain/create.vue";
import complainList from "@/pages/complain/index.vue";
import complainEdit from "@/pages/complain/edit.vue";
import utilitySetupCreate from "@/pages/setting/utilitySetup/create.vue";
import utilitySetupList from "@/pages/setting/utilitySetup/index.vue";
import utilitySetupEdit from "@/pages/setting/utilitySetup/edit.vue";
import maintenanceCostCreate from "@/pages/maintenanceCost/create.vue";
import maintenanceCostList from "@/pages/maintenanceCost/index.vue";
import maintenanceCostEdit from "@/pages/maintenanceCost/edit.vue";
import bankSetup from "@/pages/setting/bankSetup/index.vue";
import generalSetting from "@/pages/setting/general/index.vue";
import tenantInformationCreate from "@/pages/tenant/information/create.vue";
import tenantInformationList from "@/pages/tenant/information/index.vue";
import tenantInformationShow from "@/pages/tenant/information/show.vue";
import tenantInformationEdit from "@/pages/tenant/information/edit.vue";
import tenantMoveOutList from "@/pages/tenant/show-move-out.vue";

import flatBillList from "@/pages/flats/bills/index.vue";
import flatBillPayHistory from "@/pages/flats/bills/pay-history.vue";
import flatBillPayHistoryDetails from "@/pages/flats/bills/pay-history-details.vue";
import flatCostCreate from "@/pages/flats/cost/create.vue";
import flatCostList from "@/pages/flats/cost/index.vue";
import flatCostEdit from "@/pages/flats/cost/edit.vue";
import flatAccounts from "@/pages/flats/accounts/index.vue";
import buildingPaymentsList from "@/pages/buildings/accounts/payment-list.vue";
import buildingPaymentDetails from "@/pages/buildings/accounts/payment-details.vue";
import buildingAccountSummary from "@/pages/buildings/accounts/summary.vue";
import rentCreate from "@/pages/rent/create.vue";
import rentList from "@/pages/rent/index.vue";
import rentEdit from "@/pages/rent/edit.vue";
import rentInvoice from "@/pages/rent/invoice.vue";
import userProfile from "@/pages/profile/index.vue";
import moveOutRequest from "@/pages/moveOutRequest/index.vue";
import rentalReportFilter from "@/pages/reports/rental/filter-form.vue";
import mcReportFilter from "@/pages/reports/maintenance/filter-form.vue";
import visitorReportFilter from "@/pages/reports/visitor/filter-form.vue";
import complainReportFilter from "@/pages/reports/complain/filter-form.vue";
import committeCreate from "@/pages/committe/create.vue";
import committeList from "@/pages/committe/index.vue";
import committeEdit from "@/pages/committe/edit.vue";
import meetingCreate from "@/pages/meeting/create.vue";
import meetingList from "@/pages/meeting/index.vue";
import meetingEdit from "@/pages/meeting/edit.vue";
import activityLogList from "@/pages/activityLog/index.vue";
import notificationList from "@/pages/notification/index.vue";
import languageList from "@/pages/language/index.vue";
import languageTranslate from "@/pages/language/translate.vue";

let routes = [
    {
        path: "/",
        name: "home",
        components: {
            default: home,
            layouts: main,
        },
        meta: { title: "Home", permission_check: false },
    },
    {
        path: "/language/translate/:code",
        name: "language.translate",
        components: {
            default: languageTranslate,
            layouts: main,
        },
        meta: { title: "Language Translate", permission_check: false },
    },
    {
        path: "/language/list",
        name: "language.list",
        components: {
            default: languageList,
            layouts: main,
        },
        meta: { title: "Language" },
    },
    {
        path: "/notification/list",
        name: "notification.list",
        components: {
            default: notificationList,
            layouts: main,
        },
        meta: { title: "Notification List", permission_check: false },
    },
    {
        path: "/activity-log/list",
        name: "activity.log.list",
        components: {
            default: activityLogList,
            layouts: main,
        },
        meta: { title: "Activity Log" },
    },
    {
        path: "/meeting/add",
        name: "meeting.add",
        components: {
            default: meetingCreate,
            layouts: main,
        },
        meta: { title: "Meeting Add" },
    },
    {
        path: "/meeting/list",
        name: "meeting.list",
        components: {
            default: meetingList,
            layouts: main,
        },
        meta: { title: "Meeting List" },
    },
    {
        path: "/meeting/:id/edit",
        name: "meeting.edit",
        components: {
            default: meetingEdit,
            layouts: main,
        },
        meta: { title: "Meeting Edit", permission_check: false },
    },
    {
        path: "/committe/add",
        name: "committe.add",
        components: {
            default: committeCreate,
            layouts: main,
        },
        meta: { title: "Committe Add" },
    },
    {
        path: "/committe/list",
        name: "committe.list",
        components: {
            default: committeList,
            layouts: main,
        },
        meta: { title: "Committe List" },
    },
    {
        path: "/committe/:id/edit",
        name: "committe.edit",
        components: {
            default: committeEdit,
            layouts: main,
        },
        meta: { title: "Committe Edit", permission_check: false },
    },
    {
        path: "/complain-filter",
        name: "report.complain.filter",
        components: {
            default: complainReportFilter,
            layouts: main,
        },
        meta: { title: "Complain" },
    },
    {
        path: "/visitor-filter",
        name: "report.visitor.filter",
        components: {
            default: visitorReportFilter,
            layouts: main,
        },
        meta: { title: "Visitor" },
    },
    {
        path: "/maintenance-filter",
        name: "report.mc.filter",
        components: {
            default: mcReportFilter,
            layouts: main,
        },
        meta: { title: "Maintenance" },
    },
    {
        path: "/rental-filter",
        name: "report.rental.filter",
        components: {
            default: rentalReportFilter,
            layouts: main,
        },
        meta: { title: "Rent Filter" },
    },
    {
        path: "/move-out-request",
        name: "move.out.request",
        components: {
            default: moveOutRequest,
            layouts: main,
        },
        meta: { title: "Move Out Request" },
    },
    {
        path: "/userProfile",
        name: "user.profile",
        components: {
            default: userProfile,
            layouts: main,
        },
        meta: { title: "Profile", permission_check: false },
    },
    {
        path: "/rent/invoice/:id",
        name: "rent.invoice",
        components: {
            default: rentInvoice,
            layouts: main,
        },
        meta: { title: "Invoice", permission_check: false },
    },
    {
        path: "/rent/add",
        name: "rent.add",
        components: {
            default: rentCreate,
            layouts: main,
        },
        meta: { title: "Rent Generate" },
    },
    {
        path: "/rent/list",
        name: "rent.list",
        components: {
            default: rentList,
            layouts: main,
        },
        meta: { title: "Rent List" },
    },
    {
        path: "/rent/:id/edit",
        name: "rent.edit",
        components: {
            default: rentEdit,
            layouts: main,
        },
        meta: { title: "Rent Edit", permission_check: false },
    },
    {
        path: "/flats/accounts/index",
        name: "flat.accounts.index",
        components: {
            default: flatAccounts,
            layouts: main,
        },
        meta: { title: "Flat Account" },
    },
    {
        path: "/flats/cost/add",
        name: "flat.cost.add",
        components: {
            default: flatCostCreate,
            layouts: main,
        },
        meta: { title: "Flat Cost Add", permission_check: false },
    },
    {
        path: "/flats/cost/list",
        name: "flat.cost.list",
        components: {
            default: flatCostList,
            layouts: main,
        },
        meta: { title: "Flat Cost List" },
    },
    {
        path: "/flats/cost/:id/edit",
        name: "flat.cost.edit",
        components: {
            default: flatCostEdit,
            layouts: main,
        },
        meta: { title: "Flat Cost Edit", permission_check: false },
    },
    {
        path: "/flats-bill/list",
        name: "flats.bill.list",
        components: {
            default: flatBillList,
            layouts: main,
        },
        meta: { title: "Bills List" },
    },
    {
        path: "/flats-bill/pay-history",
        name: "flats.bill.pay.history",
        components: {
            default: flatBillPayHistory,
            layouts: main,
        },
        meta: { title: "Bill Pay History" },
    },
    {
        path: "/flats-bill/pay-history-details/:id",
        name: "flats.bill.pay.history.details",
        components: {
            default: flatBillPayHistoryDetails,
            layouts: main,
        },
        meta: { title: "Pay History Details", permission_check: false },
    },
    {
        path: "/tenant-information/add",
        name: "tenant.information.add",
        components: {
            default: tenantInformationCreate,
            layouts: main,
        },
        meta: { title: "Tenant Information", permission_check: false },
    },
    {
        path: "/tenant-information/list",
        name: "tenant.information.list",
        components: {
            default: tenantInformationList,
            layouts: main,
        },
        meta: { title: "Information List" },
    },
    {
        path: "/tenant-information/:id",
        name: "tenant.information.show",
        components: {
            default: tenantInformationShow,
            layouts: main,
        },
        meta: { title: "Information Show", permission_check: false },
    },
    {
        path: "/tenant-information/:id/edit",
        name: "tenant.information.edit",
        components: {
            default: tenantInformationEdit,
            layouts: main,
        },
        meta: { title: "Information Edit", permission_check: false },
    },
    {
        path: "/tenant-move-out-list",
        name: "tenant.move.out.list",
        components: {
            default: tenantMoveOutList,
            layouts: main,
        },
        meta: { title: "Move Out List" },
    },
    {
        path: "/setting/bank-setup",
        name: "setting.bank.setup",
        components: {
            default: bankSetup,
            layouts: main,
        },
        meta: { title: "Bank Setup" },
    },
    {
        path: "/setting/general",
        name: "setting.general",
        components: {
            default: generalSetting,
            layouts: main,
        },
        meta: { title: "Settings" },
    },
    {
        path: "/maintenance/add",
        name: "maintenance.add",
        components: {
            default: maintenanceCostCreate,
            layouts: main,
        },
        meta: { title: "Maintenance Add" },
    },
    {
        path: "/maintenance/list",
        name: "maintenance.list",
        components: {
            default: maintenanceCostList,
            layouts: main,
        },
        meta: { title: "Maintenance List" },
    },
    {
        path: "/maintenance/:id/edit",
        name: "maintenance.edit",
        components: {
            default: maintenanceCostEdit,
            layouts: main,
        },
        meta: { title: "Maintenance Edit", permission_check: false },
    },
    {
        path: "/setting/utility-setup/add",
        name: "setting.utility.setup.add",
        components: {
            default: utilitySetupCreate,
            layouts: main,
        },
        meta: { title: "Utility Setup", permission_check: false },
    },
    {
        path: "/setting/utility-setup/list",
        name: "setting.utility.setup.list",
        components: {
            default: utilitySetupList,
            layouts: main,
        },
        meta: { title: "Utility List" },
    },
    {
        path: "/setting/utility-setup/:id/edit",
        name: "setting.utility.setup.edit",
        components: {
            default: utilitySetupEdit,
            layouts: main,
        },
        meta: { title: "Utility Edit", permission_check: false },
    },
    {
        path: "/complain/add",
        name: "complain.add",
        components: {
            default: complainCreate,
            layouts: main,
        },
        meta: { title: "Complain Add" },
    },
    {
        path: "/complain/list",
        name: "complain.list",
        components: {
            default: complainList,
            layouts: main,
        },
        meta: { title: "Complain List" },
    },
    {
        path: "/complain/:id/edit",
        name: "complain.edit",
        components: {
            default: complainEdit,
            layouts: main,
        },
        meta: { title: "Complain Edit", permission_check: false },
    },
    {
        path: "/notice/add",
        name: "notice.add",
        components: {
            default: createNotice,
            layouts: main,
        },
        meta: { title: "Notice Add" },
    },
    {
        path: "/notice/list",
        name: "notice.list",
        components: {
            default: noticeList,
            layouts: main,
        },
        meta: { title: "Notice List" },
    },
    {
        path: "/notice/:id/edit",
        name: "notice.edit",
        components: {
            default: noticeEdit,
            layouts: main,
        },
        meta: { title: "Notice Edit", permission_check: false },
    },
    {
        path: "/tenant/add/:flat_id",
        name: "tenant.add.from.flat",
        components: {
            default: createTenant,
            layouts: main,
        },
        meta: { title: "Tenant Add", permission_check: false },
    },
    {
        path: "/tenant/add",
        name: "tenant.add",
        components: {
            default: createTenant,
            layouts: main,
        },
        meta: { title: "Tenant Add" },
    },
    {
        path: "/tenant/list",
        name: "tenant.list",
        components: {
            default: tenantList,
            layouts: main,
        },
        meta: { title: "Tenant List" },
    },
    {
        path: "/tenant/:id/edit",
        name: "tenant.edit",
        components: {
            default: tenantEdit,
            layouts: main,
        },
        meta: { title: "Tenant Edit", permission_check: false },
    },
    {
        path: "/role-permission/:id/edit",
        name: "role.permisiion.edit",
        components: {
            default: editRolePermission,
            layouts: main,
        },
        meta: { title: "Permission", permission_check: false },
    },
    {
        path: "/user/add",
        name: "user.add",
        components: {
            default: createUser,
            layouts: main,
        },
        meta: { title: "User Add" },
    },
    {
        path: "/user/list",
        name: "user.list",
        components: {
            default: userList,
            layouts: main,
        },
        meta: { title: "user List" },
    },
    {
        path: "/role/add",
        name: "role.add",
        components: {
            default: createRole,
            layouts: main,
        },
        meta: { title: "Role Add" },
    },
    {
        path: "/role/list",
        name: "role.list",
        components: {
            default: roleList,
            layouts: main,
        },
        meta: { title: "Role List" },
    },
    {
        path: "/role/:id/edit",
        name: "role.edit",
        components: {
            default: roleEdit,
            layouts: main,
        },
        meta: { title: "Role Edit", permission_check: false },
    },
    {
        path: "/building/accounts/summary",
        name: "building.accounts.summary",
        components: {
            default: buildingAccountSummary,
            layouts: main,
        },
        meta: { title: "Account Summary" },
    },
    {
        path: "/building/payments/details/:id",
        name: "payment.details",
        components: {
            default: buildingPaymentDetails,
            layouts: main,
        },
        meta: { title: "Building Payment Details", permission_check: false },
    },
    {
        path: "/building/payments/list",
        name: "building.payments.list",
        components: {
            default: buildingPaymentsList,
            layouts: main,
        },
        meta: { title: "Payment List" },
    },
    {
        path: "/building/add",
        name: "building.add",
        components: {
            default: createBuilding,
            layouts: main,
        },
        meta: { title: "Building Add" },
    },
    {
        path: "/building/list",
        name: "building.list",
        components: {
            default: buildingList,
            layouts: main,
        },
        meta: { title: "Building List" },
    },
    {
        path: "/building/:id/edit",
        name: "building.edit",
        components: {
            default: buildingEdit,
            layouts: main,
        },
        meta: { title: "Building Edit", permission_check: false },
    },
    {
        path: "/flat/add",
        name: "flat.add",
        components: {
            default: createFlat,
            layouts: main,
        },
        meta: { title: "Flat Add" },
    },
    {
        path: "/flat/upcoming-available",
        name: "flat.upcoming.available",
        components: {
            default: flatUpcomingAvailable,
            layouts: main,
        },
        meta: { title: "Upcoming Available" },
    },
    {
        path: "/flat/list",
        name: "flat.list",
        components: {
            default: flatList,
            layouts: main,
        },
        meta: { title: "Flat List" },
    },
    {
        path: "/flat/:id/edit",
        name: "flat.edit",
        components: {
            default: flatEdit,
            layouts: main,
        },
        meta: { title: "Flat Edit", permission_check: false },
    },
    {
        path: "/staff/list",
        name: "staff.list",
        components: {
            default: staffList,
            layouts: main,
        },
        meta: { title: "Staff List" },
    },
    {
        path: "/staff/create",
        name: "staff.add",
        components: {
            default: createStaff,
            layouts: main,
        },
        meta: { title: "Staff Add" },
    },
    {
        path: "/staff/:id/edit",
        name: "staff.edit",
        components: {
            default: staffEdit,
            layouts: main,
        },
        meta: { title: "Staff Edit", permission_check: false },
    },
    {
        path: "/visitor/list",
        name: "visitor.list",
        components: {
            default: visitorList,
            layouts: main,
        },
        meta: { title: "Visitor List" },
    },
    {
        path: "/visitor/create",
        name: "visitor.add",
        components: {
            default: createVisitor,
            layouts: main,
        },
        meta: { title: "Visitor Add" },
    },
    {
        path: "/visitor/:id/edit",
        name: "visitor.edit",
        components: {
            default: visitorEdit,
            layouts: main,
        },
        meta: {
            title: "Visitor Edit",
            permission_check: false,
        },
    },
    {
        path: "/login",
        name: "login",
        components: {
            default: login,
            layouts: guestLayout,
        },
        meta: { title: "Login", guestOnly: true },
    },
    {
        path: "/register",
        name: "Register",
        components: {
            default: register,
            layouts: guestLayout,
        },
        meta: { title: "Registration", guestOnly: true },
    },
];
export default routes;
