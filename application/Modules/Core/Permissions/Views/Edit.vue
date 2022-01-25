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
                / Edit Permission
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
            <v-col cols="8">
                <v-card class="mt-2">
                    <v-card-title>
                        EDIT Permission
                    </v-card-title>
                    <v-card-text class="pb-0">
                        <v-form>
                            <v-text-field class="mb-3"
                                          hide-details="auto" :error="checkErrors('name')" :error-messages="errors.name"
                                          hint="Includes alphabets and dots(.) ex permission.create"
                                          outlined dense label="Permission Name" name="name" type="text" v-model="form.name"></v-text-field>

                            <v-text-field class="mb-3"
                                          hide-details="auto" :error="checkErrors('title')" :error-messages="errors.title"
                                          hint="A general name to make user understand the goal of the permission"
                                          outlined dense label="Permission Title" name="title" type="text" v-model="form.title"></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="pt-0">
                        <v-btn dark @click="submit" :loading="loading">Update Permission</v-btn>
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
    props: ['errors','permission'],
    mounted() {
        console.log(this.permission)
    },
    data() {
        return {
            drawer: null,
            // form: this.permission,
            form: this.$inertia.form({
                id:this.permission.id,
                name:this.permission.name,
                title:this.permission.title
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
                .post(this.route('updatePermission'), {
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
        checkErrors(key) {
            return this.errors[key] !== undefined;
        }
    }
}
</script>
