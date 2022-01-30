`<template>

  <v-list dense>

    <template v-for="(key, index) in $page.props.menu_keys">
      <v-subheader
          :key="index"
          v-if="$page.props.sidebar_links[key] && $page.props.sidebar_links[key].menu_type == 'header'"
          class="mt-3 grey--text text--darken-1 text-uppercase">{{ $page.props.sidebar_links[key].title }}</v-subheader>

      <template v-else>
        <sidebar-link
            :key="index"
            v-if="checkPermissions($page.props.sidebar_links[key])"
            :icon="$page.props.sidebar_links[key].icon"
            :link="$page.props.sidebar_links[key].link == '#' ? $page.props.sidebar_links[key].link : route($page.props.sidebar_links[key].link)"
            :manage-drawer="manageDrawer"
            :title="$page.props.sidebar_links[key].title"
        ></sidebar-link>
      </template>


    </template>

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