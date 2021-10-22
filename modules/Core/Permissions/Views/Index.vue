<template>
    <app-layout>
        <template #bread-crumbs>
            <inertia-link href="/" style="text-decoration: none">
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
                <v-data-table v-if="data.length > 0"
                              :headers="headers"
                              :items="data"
                              item-key="id"
                              class="elevation-1"
                >
                    <template v-slot:item.SNO = "{ index }">
                        {{ index + 1 }}
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <div v-if="item_id == null ">
                            <inertia-link as="v-icon" small :href="route('editPermission',[item.id])" class="mr-2">
                                mdi-pencil
                            </inertia-link>
                            <v-icon
                                small
                                @click="item_id = item.id"
                            >
                                mdi-delete
                            </v-icon>
                        </div>

                        <div v-if="item_id != null && item_id == item.id" class="mt-5 mb-5">

                            <v-row justify="center">
                                <b>Are you sure you want to DELETE this item?</b>
                            </v-row>
                            <v-row justify="end">

                                <v-btn small dark @click="item_id = null">No</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn small @click="remove">I'm Sure</v-btn>
                            </v-row>
                        </div>
                    </template>
                </v-data-table>
                <v-card v-else>
                    <v-card-text>
                        <v-icon>warning</v-icon>
                        <p>
                            No Data Available for this table
                        </p>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>

    </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'

export default {
    components: {
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
                { text: 'SNO', value: 'SNO', sortable: false },
                {
                    text: 'Name', align: 'start',
                    sortable: true, value: 'name',
                },
                {
                    text: 'Title', align: 'start',
                    sortable: true, value: 'title',
                },
                { text: 'Actions', value: 'actions', sortable: false },
            ]
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
