<template>
    <dev-configs-index>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Statuses</h3>
          <div class="card-tools">
            <inertia-link class="btn btn-primary btn-sm" :href="route('createStatus')">
              <i class="fa fa-plus "></i>
              Add Status
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
                ID
              </th>
              <th style="width: 20%">
                Color
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
                  {{ item.name }}
                </a>
                <br />
                <small>
                  Created {{ item.created_at }}
                </small>
              </td>
              <td>
                {{item.id}}
              </td>
              <td>
                {{item.color}}
              </td>
              <td class="project-actions text-right">
                <inertia-link class="btn btn-info btn-sm" :href="route('editStatus',[item.id])">
                  <i class="fas fa-pencil-alt"></i>
                  Edit
                </inertia-link>
                <a class="btn btn-danger btn-sm" href="#" @click="item_id = item.id"
                   data-toggle="modal" data-target="#delete_status">
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

      <custom-modal
          :id="'delete_status'"
          :color="'danger'"
          :title="'Delete Status'"
          :type="'sm'"
      >

        <template #body>
          Are you sure you want to delete this Status?
        </template>

        <template #action_button>
          <button type="button" class="btn btn-outline-light" @click="remove">
            Yes, I am Sure
          </button>
        </template>

      </custom-modal>

    </dev-configs-index>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import DevConfigsIndex from "../../DevConfigsIndex";
import CustomModal from "../../../../../Theme/Components/CustomModal";

export default {
    components: {
      CustomModal,
      DevConfigsIndex,
        AppLayout,
    },
    props: ['data', 'errors'],
    mounted() {
        console.log(this.$page.props.statuses);
    },
    data() {
        return {
            item_id: null,
            drawer: null,
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
            this.$inertia.post(route('deleteStatus'), {
                id: this.item_id
            },{
              onFinish: () => {
                this.item_id = null;
                $('#delete_status').trigger('click');
              }
            });
        },
    }
}
</script>
