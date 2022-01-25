<template>
    <app-layout>
        <template #bread-crumbs>
            <inertia-link href="/" style="text-decoration: none">
                <v-icon size="16" style="margin-top: -2px">home</v-icon>
            </inertia-link>
            /
            <inertia-link href="/users" style="text-decoration: none">
                Users List
            </inertia-link>
            <span class="text-md">
                / Manage User Permissions
            </span>

            <br/>
            <inertia-link as="v-btn" small href="/users" style="text-decoration: none" class="mt-2">
                <v-icon>arrow_back</v-icon>
                Back
            </inertia-link>
        </template>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <v-row align="center" justify="center" align-content="center">
            <v-col cols="8">
                <v-card class="mt-2">
                    <v-card-title>
                        Manage Permissions for User <{{name}}>
                    </v-card-title>
                    <v-card-text class="pb-0">

                        <v-row class="pt-3 pb-3 pl-2">
                            <v-col cols="6" class="pa-0 mb-1" v-for="permission in permissions" :key="permission.name">
                                <v-checkbox  :label="permission.title" class="mt-0 " hide-details
                                             :value="permission.name" v-model="permission_names" >
                                </v-checkbox>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions class="pt-0 mt-2">
                        <v-btn dark @click="submit" :loading="loading">Assign Permissions</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

        </v-row>

    </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'

export default {
    components: {
        AppLayout,
    },
    props: ['data','user_permissions', 'permissions','errors'],
    mounted() {
        console.log(this.data)
    },
    data() {
        return {
            drawer: null,
            form: this.$inertia.form({
                user_id: this.data.id,
            }),
            name: this.data.name,
            loading:false,
            permission_names : this.user_permissions,
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.form
                .transform(data => ({
                    ... data,
                    permission_names: this.permission_names
                }))
                .post(this.route('saveUserPermissions'), {
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        console.log(this.errors)
                    },
                    onFinish: () => {
                        this.loading = false;
                        this.$inertia.visit('/users')
                    },
                })
        }
    }
}
</script>
