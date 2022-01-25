<template>
  <v-app id="inspire">

    <v-navigation-drawer
        v-model="drawer"
        :permanent="$vuetify.breakpoint.mdAndUp"
        :temporary="!$vuetify.breakpoint.mdAndUp"
        app
    >
      <v-list-item>
        <v-list-item-avatar>
          <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>
            {{ $page.props.user.name }}
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <sidebar
          :manage-drawer="manageDrawer"
      ></sidebar>

    </v-navigation-drawer>
    <v-app-bar app dense>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>
        {{ $page.props.APP_NAME }}
      </v-toolbar-title>
      <v-spacer></v-spacer>

      <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn v-if="$page.props.user" v-bind="attrs" v-on="on"
                 text>
            <v-icon>mdi-account</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item link>
            <inertia-link :href="route('userProfile')" as="v-list-item-title">
              Profile
            </inertia-link>
          </v-list-item>
          <v-list-item link>
            <v-list-item-title @click="logout">
              Logout
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>


      <!--            <inertia-link-->
      <!--                v-if="$page.props.user" href="/dashboard"-->
      <!--                class="text-sm text-gray-700"-->
      <!--                style="text-decoration: none"-->
      <!--            >-->
      <!--                <v-icon>account_circle</v-icon>-->
      <!--                {{ $page.props.user.name }}-->
      <!--            </inertia-link>-->
    </v-app-bar>

    <!-- Sizes your content based upon application components -->
    <v-main>

      <!-- Provides the application the proper gutter -->
      <v-container fluid>
        <v-row>
          <v-col class="pb-0" cols="12">
            <!-- Page Heading -->
            <header class="bg-white shadow">
              <slot name="header"></slot>
            </header>
          </v-col>
          <v-col class="pt-0 text-sm" cols="12" style="font-size: small">
            <slot name="bread-crumbs"></slot>
          </v-col>
        </v-row>

        <!-- Page Content -->
        <main>
          <slot></slot>
        </main>
      </v-container>
    </v-main>

    <v-footer app>
      Copyright &copy; 2021 {{ $page.props.APP_NAME }}
    </v-footer>
  </v-app>

</template>

<script>
import Sidebar from "@/Theme/Components/sidebar";
export default {
  components: {Sidebar},
  data() {
    return {
      drawer: this.$vuetify.breakpoint.mdAndUp,
      items: [
        {title: 'Dashboard', icon: 'mdi-view-dashboard', link: '/dashboard', permission: "dashboard.view"},
        {title: 'Permissions', icon: 'mdi-forum', link: '/permissions', permission: "permissions.view"},
        {title: 'Users', icon: 'mdi-account', link: '/users', permission: "users.view"},
      ],
      user_items: [
        {title: 'Profile', icon: 'mdi-view-dashboard'},
        {title: 'Logout', icon: 'mdi-forum',},
      ],
    }
  },

  methods: {
    switchToTeam(team) {
      this.$inertia.put(route('current-team.update'), {
        'team_id': team.id
      }, {
        preserveState: false
      })
    },

    logout() {
      this.$inertia.post(route('logout'));
    },

    profile() {
      this.$inertia.post(route('userProfile'));
    },

    manageDrawer() {
      if (this.drawer) {
        this.drawer = false;
      }
    }
  }
}
</script>

<style>
html {
  overflow-y: auto
}
.v-application--is-ltr .v-list-item__action:first-child, .v-application--is-ltr .v-list-item__icon:first-child {
  margin-right: 16px;
}
.v-select.v-input--dense .v-chip {
  margin: 4px 4px;
}

.up_icon > span {
  display: flex;
  flex-direction: column;
}
</style>
