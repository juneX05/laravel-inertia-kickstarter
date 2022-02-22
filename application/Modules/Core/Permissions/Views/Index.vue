<template>
    <app-layout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permissions
            </h2>
        </template>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Permissions</h3>
          <div class="card-tools">
            <inertia-link class="btn btn-primary btn-sm" :href="route('createPermission')">
              <i class="fa fa-plus "></i>
              Add Permission
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
                Name
              </th>
              <th style="width: 20%">
                Title
              </th>
              <th style="width: 30%">
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(permission, index) in data" :key="index">
              <td>
                #
              </td>
              <td>
                <a>
                  {{ permission.name }}
                </a>
                <br />
                <small>
                  Created {{ permission.created_at }}
                </small>
              </td>
              <td>
                {{permission.title}}
              </td>
              <td class="project-actions text-right">
                <a class="btn btn-primary btn-sm" href="#">
                  <i class="fas fa-folder">
                  </i>
                  View
                </a>
                <a class="btn btn-info btn-sm" href="#">
                  <i class="fas fa-pencil-alt">
                  </i>
                  Edit
                </a>
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
