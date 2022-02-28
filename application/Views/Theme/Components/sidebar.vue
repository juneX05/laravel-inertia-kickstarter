<template>
  <ul
      class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent"
      data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->


    <template v-for="(item, parent_index) in sidebar_links">

      <li class="nav-header" v-if="item.menu_type === 'header'">
        {{ item.title }}
      </li>

      <template v-else>
        <li class="nav-item" v-if="!item.children" :key="parent_index">
          <inertia-link :href="item.link_type === 'hard-link'? item.link : route(item.link)" class="nav-link"
             :class="{active: current_route === item.link}">
            <i :class="'nav-icon fas ' + item.icon"></i>
            <p>
              {{ item.title }}
            </p>
          </inertia-link>
        </li>

        <li class="nav-item" :key="parent_index" v-else
            :class="{'menu-open': getChildrenRoutes(item.children).includes(current_route)}">
          <a href="#" class="nav-link" :class="{'active': getChildrenRoutes(item.children).includes(current_route)}">
            <i :class="'nav-icon fas ' + item.icon"></i>
            <p>
              {{ item.title }}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item" v-for="(child, child_index) in item.children" :key="child_index">
              <inertia-link :href="child.link_type === 'hard-link'? child.link : route(child.link)" class="nav-link"
                 :class="{active: current_route === child.link}">
                <i :class="'nav-icon fas ' + child.icon"></i>
                <p>
                  {{ child.title }}
                </p>
              </inertia-link>
            </li>

          </ul>
        </li>
      </template>


    </template>

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
  data() {
    return {
      current_route: this.$page.props.current_route,
      sidebar_links: this.$page.props.sidebar_links,
    }
  },
  computed:{

  },
  methods: {
    getChildrenRoutes(route) {
      const keys = Object.keys(route);
      let routes = [];
      for (let i =0; i < keys.length; i++) {
        let key = keys[i];
        let child_route = route[key];
        routes.push(child_route.link);
      }
      return routes;
    },
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