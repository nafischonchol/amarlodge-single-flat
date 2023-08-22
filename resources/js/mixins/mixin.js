import moment from "moment";
export default {
    data() {
        return {
            isLoading: false,
        };
    },
    methods: {
        loader: function (loader) {
            this.isLoading = loader;
            const appLoader = $("#loader");
            const layouts = $("#layouts");
            if (loader === true) {
                appLoader.show();
                layouts.show();
            } else if (loader === false) {
                appLoader.hide();
                layouts.hide();
            } else {
                appLoader.show();
                layouts.show();
                setTimeout(() => {
                    appLoader.hide();
                    layouts.hide();
                }, 500);
            }
        },
        menuToggle() {
            if (window.innerWidth <= 768) {
                $(".wrapper").hasClass("toggled")
                    ? ($(".wrapper").removeClass("toggled"),
                      $(".sidebar-wrapper").unbind("hover"))
                    : ($(".wrapper").addClass("toggled"),
                      $(".sidebar-wrapper").hover(
                          function () {
                              $(".wrapper").addClass("sidebar-hovered");
                          },
                          function () {
                              $(".wrapper").removeClass("sidebar-hovered");
                          }
                      ));
            }
        },
        convertToUpperCase(text) {
            if (text) return text.toUpperCase();
            return text;
        },
        currentDate() {
            return new Date().toISOString().substr(0, 10);
        },
        formatDate(date) {
            if (date) return moment(date).format("DD MMMM, YYYY");
            return date;
        },
        formatMonth(date) {
            return moment(date).format("MMMM , YYYY");
        },
        formatDateTime(date) {
            if (date) return moment(date).format("DD MMMM, YYYY h:mmA");
            return date;
        },
        getTimeAgo(timestamp) {
            return moment(timestamp).fromNow();
        },
        activeStatus(status) {
            const statusMap = {
                0: "Inactive",
                1: "Active",
            };
            return statusMap[status] || "Unknown";
        },
        statusName(status) {
            const statusMap = {
                0: "Created",
                1: "Confirm",
                2: "Pending",
                3: "Cancel",
            };
            return statusMap[status] || "Unknown";
        },
        yesNo(item) {
            return item == 1 ? "Yes" : "No";
        },
        paymentStatus(status) {
            const statusMap = {
                0: "Due",
                1: "Confirm",
                2: "Payment Pending",
                3: "Cancel",
            };
            return statusMap[status] || "Unknown";
        },
        utilityField() {
            return [
                "water_bill",
                "gas_bill",
                "security_bill",
                "garbage_bill",
                "service_charge",
                "electric_bill",
                "other_bill",
            ];
        },
        utilityAndRentField() {
            return [
                "rent_amount",
                "water_bill",
                "gas_bill",
                "security_bill",
                "garbage_bill",
                "service_charge",
                "electric_bill",
                "other_bill",
            ];
        },
    },
};
