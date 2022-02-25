<template>

  <v-list dense>
    <template v-for="(link, index) in $page.props.sidebar_links" >
      <v-subheader
          v-if="link.type == 'header'" :key="index"
          class="mt-3 grey--text text--darken-1 text-uppercase">
        {{ link.title }}
      </v-subheader>

      <template v-else>

        <v-list-group v-if="link.children" :key="index" no-action>
          <template v-slot:activator>
            <v-list-item-action>
              <v-icon>{{ link.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ link.title }}</v-list-item-title>
            </v-list-item-content>
          </template>

          <template v-for="(child,child_index) in link.children">

            <sidebar-link :key="child_index"
                          v-if="checkPermissions(child.permissions)"
                          :icon="child.icon"
                          :link="child.link == '#' ? child.link : route(child.link)"
                          :manage-drawer="manageDrawer"
                          :title="child.title"
            ></sidebar-link>

          </template>
        </v-list-group>

        <sidebar-link :key="index"
                      v-if="checkPermissions(link.permissions) && !link.children"
                      :icon="link.icon"
                      :link="link.link == '#' ? link.link : route(link.link)"
                      :manage-drawer="manageDrawer"
                      :title="link.title"
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