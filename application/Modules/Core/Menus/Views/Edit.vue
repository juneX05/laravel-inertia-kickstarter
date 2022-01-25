<template>
    <app-layout>
      <template #bread-crumbs>
        <inertia-link :href="route('home')" style="text-decoration: none">
          <v-icon size="16" style="margin-top: -2px">home</v-icon>
        </inertia-link>
        /
        <inertia-link :href="route('viewMenus')" style="text-decoration: none">
          Menus List
        </inertia-link>
        <span class="text-md">
                / Edit Menu
            </span>

        <br/>
        <inertia-link :href="route('viewMenus')" as="v-btn" class="mt-2" small style="text-decoration: none">
          <v-icon>arrow_back</v-icon>
          Back
        </inertia-link>
      </template>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Menus
        </h2>
      </template>

        <v-row align="center" align-content="center" justify="center">
            <v-col cols="8">
                <v-card class="mt-2">
                    <v-card-title>
                        EDIT Menu
                    </v-card-title>
                    <v-card-text class="pb-0">
                      <_menuForm :errors="errors" :form="form"></_menuForm>
                    </v-card-text>
                    <v-card-actions class="pt-0">
                        <v-btn :loading="loading" dark @click="submit">Update Menu</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

        </v-row>

    </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import _menuForm from "@/Core/Menus/Views/menuForm";

export default {
    components: {
      _menuForm,
        AppLayout,
    },
    props: ['errors','menu'],
    mounted() {
        console.log(this.menu)
    },
    data() {
        return {
            drawer: null,
            // form: this.permission,
            form: this.$inertia.form({
                id:this.menu.id,
                name:this.menu.name,
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
                .post(this.route('updateMenu'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewMenus'))
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
