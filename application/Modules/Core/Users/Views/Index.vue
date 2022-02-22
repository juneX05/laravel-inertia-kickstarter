<template>
    <app-layout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Users</h3>
          <div class="card-tools">
            <inertia-link class="btn btn-primary btn-sm" :href="route('createUser')">
              <i class="fa fa-plus "></i>
              Add User
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
                Email
              </th>
              <th style="width: 20%">
                Profile Photo
              </th>
              <th style="width: 8%" class="text-center">
                Status
              </th>
              <th style="width: 30%">
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(user, index) in data" :key="index">
              <td>
                #
              </td>
              <td>
                <a>
                  {{ user.name }}
                </a>
                <br />
                <small>
                  Created {{ user.created_at }}
                </small>
              </td>
              <td>
                {{user.email}}
              </td>
              <td>
                <ul class="list-inline">
                  <li class="list-inline-item">
                    <img alt="Avatar" class="table-avatar" :src="user.profile_photo_url">
                  </li>
                </ul>
              </td>
              <td class="project-state">
                <span class="badge badge-success">Success</span>
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

export default {
    components: {
        AppLayout,
    },
    props: ['data', 'errors'],
    mounted() {
        console.log(this.$page.props.users);
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
                    text: 'Email', align: 'start',
                    sortable: true, value: 'email',
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
            this.$inertia.post(route('deleteUser'), {
                id: this.item_id
            },{
                onFinish: () => this.item_id = null
            });
        },
    }
}
</script>
