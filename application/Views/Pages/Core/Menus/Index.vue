<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Menus
            </h2>
        </template>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Menus</h3>
          <div class="card-tools">
            <inertia-link class="btn btn-primary btn-sm" :href="route('createMenu')">
              <i class="fa fa-plus "></i>
              Add Menu
            </inertia-link>
            <inertia-link class="btn btn-primary btn-sm" :href="route('managePositions')">
              <i class="fa fa-plus "></i>
              Manage Positions
            </inertia-link>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <thead>
            <tr>
              <th style="width: 1%">
                #
              </th>
              <th style="width: 20%">
                Title
              </th>
              <th style="width: 20%">
                Icon
              </th>
              <th style="width: 20%">
                Link
              </th>
              <th style="width: 20%">
                Link Type
              </th>
              <th style="width: 20%">
                Permission
              </th>
              <th style="width: 20%">
                Parent
              </th>
              <th style="width: 30%">
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in data" :key="index">
              <td>
                #
              </td>
              <td>
                <a>
                  {{ item.title }}
                </a>
                <br />
                <small>
                  Created {{ item.created_at }}
                </small>
              </td>
              <td>
                {{item.icon}}
              </td>
              <td>
                {{item.link}}
              </td>
              <td>
                {{item.link_type}}
              </td>
              <td>

                {{item.permissions}}
              </td>
              <td>
                {{item.parent}}
              </td>
              <td class="project-actions text-right">
                <inertia-link class="btn btn-info btn-sm" :href="route('editPermission',[item.id])">
                  <i class="fas fa-pencil-alt"></i>
                  Edit
                </inertia-link>
                <a class="btn btn-danger btn-sm" href="#">
                  <i class="fas fa-trash">
                  </i>
                  Delete
                </a>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
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
        console.log(this.$page.props.menus);
    },
    data() {
        return {
            item_id: null,
            drawer: null,
            headers: [
                { text: 'SNO', value: 'SNO', sortable: false },
                {
                    text: 'Title', align: 'start',
                    sortable: true, value: 'title',
                },
                {
                    text: 'Icon', align: 'start',
                    sortable: true, value: 'icon',
                },
                {
                    text: 'Link', align: 'start',
                    sortable: true, value: 'link',
                },
                {
                    text: 'Link Type', align: 'start',
                    sortable: true, value: 'link_type',
                },
                {
                    text: 'Permission', align: 'start',
                    sortable: true, value: 'permissions',
                },
                {
                    text: 'Parent', align: 'start',
                    sortable: true, value: 'parent',
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
            this.$inertia.post(route('deleteMenu'), {
                id: this.item_id
            },{
                onFinish: () => this.item_id = null
            });
        },
    }
}
</script>
