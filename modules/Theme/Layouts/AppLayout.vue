<template>
    <v-app id="inspire">

        <v-navigation-drawer
            v-model="drawer"
            :temporary="!$vuetify.breakpoint.mdAndUp"
            :permanent="$vuetify.breakpoint.mdAndUp"
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

            <v-list dense>
                <inertia-link as="v-list-item" :href="item.link" v-for="item in items"
                              :key="item.title" v-if="!item.permission || $page.props.current_user_permissions.includes(item.permission)"
                              link
                              @click = "manageDrawer">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </inertia-link>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar app dense>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>
              {{ $page.props.APP_NAME }}
            </v-toolbar-title>
            <v-spacer></v-spacer>

            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn text v-if="$page.props.user" v-bind="attrs"
                           v-on="on">
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
                    <v-col cols="12" class="pb-0">
                        <!-- Page Heading -->
                        <header class="bg-white shadow">
                            <slot name="header"></slot>
                        </header>
                    </v-col>
                    <v-col cols="12" class="pt-0 text-sm" style="font-size: small">
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
            Copyright &copy; 2021  {{ $page.props.APP_NAME }}
        </v-footer>
    </v-app>

</template>

<script>

    export default {

        data () {
            return {
                drawer: this.$vuetify.breakpoint.mdAndUp,
                items: [
                    { title: 'Dashboard', icon: 'mdi-view-dashboard', link:'/dashboard', permission: "dashboard.view" },
                    { title: 'Permissions', icon: 'mdi-forum', link:'/permissions', permission:"permissions.view" },
                    { title: 'Users', icon: 'mdi-account', link:'/users', permission:"users.view" },
                ],
                user_items: [
                    { title: 'Profile', icon: 'mdi-view-dashboard' },
                    { title: 'Logout', icon: 'mdi-forum', },
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
                if (this.drawer){
                    this.drawer = false;
                }
            }
        }
    }
</script>

