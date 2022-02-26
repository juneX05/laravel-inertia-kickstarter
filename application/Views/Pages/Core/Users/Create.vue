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
                / Create User
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
                        Create New User
                    </v-card-title>
                    <v-card-text class="pb-0">
                        <v-form>
                            <div class="mb-3">
                                <v-text-field hide-details="auto" :error="checkErrors('name')" :error-messages="errors.name"
                                    outlined dense label="User Name" name="name" type="text" v-model="form.name"></v-text-field>
                            </div>
                            <div class="mb-3">
                                <v-text-field hide-details="auto" :error="checkErrors('email')" :error-messages="errors.email"
                                    outlined dense label="User Email" name="email" type="email" v-model="form.email"></v-text-field>
                            </div>
                            <div class="mb-3">
                                <v-text-field hide-details="auto" :error="checkErrors('password')"
                                    outlined dense label="User Password" name="password" type="password" v-model="form.password"></v-text-field>
                            </div>
                            <div class="mb-3">
                                <v-text-field hide-details="auto" :error="checkErrors('password')" :error-messages="errors.password"
                                              outlined dense label="Repeat Password" name="password_confirmation" type="password" v-model="form.password_confirmation"></v-text-field>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="ml-2">
                        <v-btn dark @click="submit" :loading="loading">Save User</v-btn>
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
    props: ['errors'],
    data() {
        return {
            drawer: null,
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            }),
            loading:false
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.form
                .transform(data => ({
                    ... data,
                }))
                .post(this.route('saveUser'), {
                    onSuccess: () => {
                        this.$inertia.visit('/users')
                    },
                    onError: () => {
                        console.log(this.errors)
                    },
                    onFinish: () => {
                        this.loading = false;
                    },
                })
        },
        checkErrors(key) {
            return this.errors[key] !== undefined;
        }
    }
}
</script>
