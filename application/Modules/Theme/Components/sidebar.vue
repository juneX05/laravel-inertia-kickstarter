<template>
  <ul
      class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent"
      data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Users
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <inertia-link class="nav-link " :href="route('viewUsers')"  link>
            <i class="far fa-circle nav-icon"></i>
            <p>View Users</p>
          </inertia-link>
        </li>
        <li class="nav-item">
          <inertia-link class="nav-link " :href="route('createUser')"  link>
            <i class="far fa-circle nav-icon"></i>
            <p>Add User</p>
          </inertia-link>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Permissions
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <inertia-link class="nav-link " :href="route('viewPermissions')"  link>
            <i class="far fa-circle nav-icon"></i>
            <p>View Permissions</p>
          </inertia-link>
        </li>
        <li class="nav-item">
          <inertia-link class="nav-link " :href="route('createPermission')"  link>
            <i class="far fa-circle nav-icon"></i>
            <p>Add Permission</p>
          </inertia-link>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Settings
        </p>
      </a>
    </li>
  </ul>
</template>

<script>
import SidebarLink from "@/Theme/Components/sidebarLink";
export default {
  name: "sidebar",
  components: {SidebarLink},
  props: {
    // manageDrawer: {
    //   type: Function,
    //   required: true
    // }
  },
  methods: {
    checkPermissions(menu) {
      let permissions = null
      let allowed = false;
      if (menu.permissions) {
        permissions = menu.permissions
      } else {
        return true;
      }

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