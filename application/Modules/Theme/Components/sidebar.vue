<template>

  <v-list dense>

    <sidebar-link
        v-if="checkPermissions(['dashboard.view'])"
        :icon="'view-dashboard'"
        :link="route('viewDashboard')"
        :manage-drawer="manageDrawer"
        :title="'Dashboard'"
    ></sidebar-link>

    <sidebar-link
        :icon="'calendar'"
        :link="route('viewCalendars')"
        :manage-drawer="manageDrawer"
        :title="'Calendar'"
    ></sidebar-link>

    <v-subheader class="mt-3 grey--text text--darken-1 text-uppercase">MENU</v-subheader>

    <sidebar-link
        :icon="'account-details'"
        :link="route('viewCustomers')"
        :manage-drawer="manageDrawer"
        :title="'Customers'"
    ></sidebar-link>

    <sidebar-link
        :icon="'view-agenda'"
        :link="route('viewRooms')"
        :manage-drawer="manageDrawer"
        :title="'Rooms'"
    ></sidebar-link>

    <sidebar-link
        :icon="'package'"
        :link="route('viewPackages')"
        :manage-drawer="manageDrawer"
        :title="'Packages'"
    ></sidebar-link>

    <sidebar-link
        :icon="'folder-plus-outline'"
        :link="route('viewBookings')"
        :manage-drawer="manageDrawer"
        :title="'Bookings'"
    ></sidebar-link>

    <sidebar-link
        :icon="'receipt'"
        :link="route('viewInvoices')"
        :manage-drawer="manageDrawer"
        :title="'Invoices'"
    ></sidebar-link>

    <sidebar-link
        :icon="'credit-card-settings-outline'"
        :link="route('viewPayments')"
        :manage-drawer="manageDrawer"
        :title="'Payments'"
    ></sidebar-link>

    <sidebar-link
        :icon="'account-circle-outline'"
        :link="route('viewUsers')"
        :manage-drawer="manageDrawer"
        :title="'Users'"
    ></sidebar-link>

    <sidebar-link
        :icon="'chart-box-plus-outline'"
        :link="route('viewReports')"
        :manage-drawer="manageDrawer"
        :title="'Reports'"
    ></sidebar-link>

    <v-subheader class="mt-3 grey--text text--darken-1 text-uppercase">UTILITIES</v-subheader>

    <sidebar-link
        :icon="'cog-pause-outline'"
        :link="route('viewConfigurations')"
        :manage-drawer="manageDrawer"
        :title="'Configurations'"
    ></sidebar-link>

    <sidebar-link
        :icon="'developer-board'"
        :link="route('viewDevConfigs')"
        :manage-drawer="manageDrawer"
        :title="'Developer'"
    ></sidebar-link>

    <sidebar-link
        :icon="'package-variant-closed'"
        :link="'#'"
        :manage-drawer="manageDrawer"
        :title="'Site Map'"
    ></sidebar-link>

  </v-list>
</template>

<script>
import SidebarLink from "@/Theme/Components/sidebarLink";
export default {
  name: "sidebar",
  components: {SidebarLink},
  props: {
    manageDrawer: {
      type: Function,
      required: true
    }
  },
  methods: {
    checkPermissions(permissions) {
      console.log(this.$page.props);
      let allowed = false;
      if (Array.isArray(permissions)) {
        permissions.forEach((permission) => {
          console.log(permission, '');
          allowed = this.$page.props.current_user_permissions.includes(permission);
        });
      } else {
        allowed = this.$page.props.current_user_permissions.includes(permissions);
      }

      return allowed;
    }
  }
}
</script>

<style scoped>

</style>