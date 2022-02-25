<template>
    <app-layout>
        <template #bread-crumbs>
            <inertia-link :href="route('home')" style="text-decoration: none">
                <v-icon size="16" style="margin-top: -2px">home</v-icon>
            </inertia-link>
            /
            <inertia-link :href="route('viewPermissions')" style="text-decoration: none">
                Permissions List
            </inertia-link>
            <span class="text-md">
                / Manage User Permissions
            </span>

            <br/>
            <inertia-link :href="route('viewPermissions')" as="v-btn" class="mt-2" small style="text-decoration: none">
                <v-icon>arrow_back</v-icon>
                Back
            </inertia-link>
        </template>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permissions
            </h2>
        </template>

        <v-row align="center" justify="center" align-content="center">
            <v-col sm="12" md="8" lg="6">
                <v-card class="mt-2">
                    <v-card-title>
                        Manage Permissions for a User
                    </v-card-title>
                    <v-card-text class="pb-0">
                        <v-select
                            v-model="form.user_id"
                            hint="Select User to Manage Permissions"
                            no-data-text="Select User to manage"
                            :items="users"
                            item-text="name"
                            item-value="id"
                            label="Select User"
                            persistent-hint
                            single-line
                            clearable
                            @change="getUserPermissions"
                            :error="checkErrors('user_id')"
                            :error-messages="errors.user_id"
                        ></v-select>

                        <div v-if="form.user_id" style="max-height: 35vh; overflow-x: hidden">
                            <v-progress-circular v-if="permissions_loading"
                                                 indeterminate
                                                 color="primary"
                            ></v-progress-circular>
                            <v-row v-else class="pt-3 pb-3 pl-2">
                                <v-col cols="12" sm="12" md="6" class="pa-0 mb-1" v-for="permission in permissions" :key="permission.name">
                                    <v-checkbox  :label="permission.title" class="mt-0 " hide-details
                                                :value="permission.name" v-model="permission_names" >
                                    </v-checkbox>
                                </v-col>
                            </v-row>

                        </div>
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
    props: ['users','permissions','errors'],
    mounted() {
    },
    data() {
        return {
            drawer: null,
            form: this.$inertia.form({
                user_id: '',
            }),
            loading:false,
            permission_names : [],
            permissions_loading:false
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
                .post(this.route('saveUsersPermissions'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewPermissions'))
                    },
                    onError: () => {
                        console.log(this.errors)
                    },
                    onFinish: () => {
                        this.loading = false;
                    },
                })
        },
        getUserPermissions() {
            this.permissions_loading = true;
            axios.post(this.route('getUserPermissions'),{
                user_id: this.form.user_id
            })
            .then( response => {
                this.permission_names = response.data.user_permissions
                this.permissions_loading = false;
            });
        },
        checkErrors(key) {
            return this.errors[key] !== undefined;
        }
    }
}
</script>
