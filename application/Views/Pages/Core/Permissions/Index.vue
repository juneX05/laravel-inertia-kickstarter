<template>
    <app-layout>
        <template #bread-crumbs>
            <inertia-link :href="route('home')" style="text-decoration: none">
                <v-icon size="16" style="margin-top: -2px">home</v-icon>
            </inertia-link>
            <span class="text-md">
                / Permissions List
            </span>

        </template>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permissions
            </h2>
        </template>

        <v-col cols="12">
            <v-row>
                <v-col cols="12">
                    <inertia-link as="v-btn" small :href="route('createPermission')" class="float-end">
                        <v-icon>add</v-icon>
                        Add Permission
                    </inertia-link>
                    <inertia-link as="v-btn" small :href="route('manageUsersPermissions')" class="float-end mr-2">
                        <v-icon>add</v-icon>
                        Manage User Permissions
                    </inertia-link>
                </v-col>
            </v-row>
            <div class="mt-3">

              <custom-data-table
                  :delete-route="'deletePermission'"
                  :edit-route="'editPermission'"
                  :headers="headers"
                  :items="data"
              ></custom-data-table>

            </div>
        </v-col>

    </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import CustomDataTable from "@/Theme/Components/customDataTable";

export default {
    components: {
      CustomDataTable,
      AppLayout,
    },
    props: ['data', 'errors'],
    mounted() {
        console.log(this.$page.props.permissions);
    },
    data() {
        return {
            item_id: null,
            drawer: null,
            headers: [
              {text: 'SNO', value: 'SNO', sortable: false},
              {
                text: 'Name', align: 'start',
                sortable: true, value: 'name',
              },
              {
                text: 'Title', align: 'start',
                sortable: true, value: 'title',
              },
              {text: 'Actions', value: 'actions', sortable: false},
            ],
          page_start: 0
        }
    },

    methods: {
        submit() {
            this.form
                .transform(data => ({
                    ... data,
                    remember: this.form.remember ? 'on' : ''
                }))
                .post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
        },
        remove() {
            this.$inertia.post(route('deletePermission'), {
                id: this.item_id
            },{
                onFinish: () => this.item_id = null
            });
        },
    }
}
</script>
