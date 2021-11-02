<template>
    <!-- App.vue -->

    <v-app id="inspire">
        <v-app-bar app dense>
            <v-toolbar-title>
              {{$page.props.APP_NAME}}
            </v-toolbar-title>
            <v-spacer></v-spacer>


            <inertia-link href="/dashboard" class="v-btn--text" style="text-decoration: none" v-if="$page.props.user">
                <v-btn text>
                    <v-icon>account_circle</v-icon> {{ $page.props.user.name }}
                </v-btn>
            </inertia-link>

<!--            <inertia-link-->
<!--                v-if="$page.props.user" href="/dashboard"-->
<!--                class="text-sm text-gray-700"-->
<!--                style="text-decoration: none"-->
<!--            >-->
<!--                <v-icon>account_circle</v-icon>-->
<!--                {{ $page.props.user.name }}-->
<!--            </inertia-link>-->

            <template v-else>
                <inertia-link :href="route('login')" class="text-sm text-gray-700 underline">
                    Login
                </inertia-link>

                <inertia-link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </inertia-link>
            </template>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>

            </v-container>
        </v-main>

        <v-footer app>
            Copyright &copy; 2021 {{$page.props.APP_NAME}}
        </v-footer>
    </v-app>
</template>

<script>
export default {
    components: {},
    data: () => ({
        drawer: null
    }),

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    }
}
</script>
