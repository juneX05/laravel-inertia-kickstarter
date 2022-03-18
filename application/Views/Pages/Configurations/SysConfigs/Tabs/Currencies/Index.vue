<template>
    <sys-config-index>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Currencies</h3>
          <div class="card-tools">
            <inertia-link class="btn btn-primary btn-sm" :href="route('createCurrency')">
              <i class="fa fa-plus "></i>
              Add Currency
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
                Abbreviation
              </th>
              <th style="width: 20%">
                Symbol
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
                {{item.abbreviation}}
              </td>
              <td>
                {{item.symbol}}
              </td>
              <td class="project-actions text-right">
                <inertia-link class="btn btn-info btn-sm" :href="route('editCurrency',[item.id])">
                  <i class="fas fa-pencil-alt"></i>
                  Edit
                </inertia-link>
                <a class="btn btn-danger btn-sm" href="#" @click="item_id = item.id"
                   data-toggle="modal" data-target="#delete_currency">
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
          :id="'delete_currency'"
          :color="'danger'"
          :title="'Delete Currency'"
          :type="'sm'"
      >

        <template #body>
          Are you sure you want to delete this Currency?
        </template>

        <template #action_button>
          <button type="button" class="btn btn-outline-light" @click="remove">
            Yes, I am Sure
          </button>
        </template>

      </custom-modal>
    </sys-config-index>
</template>

<script>
import SysConfigIndex from "../../SysConfigIndex";
import CustomModal from "../../../../../Theme/Components/CustomModal";

export default {
    components: {
      CustomModal,
      SysConfigIndex,
    },
    props: ['data', 'errors'],
    mounted() {
        console.log(this.$page.props.currencies);
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
                    text: 'Abbreviation', align: 'start',
                    sortable: true, value: 'abbreviation',
                },
                {
                    text: 'Symbol', align: 'start',
                    sortable: true, value: 'symbol',
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
            this.$inertia.post(route('deleteCurrency'), {
                id: this.item_id
            },{
              onFinish: () => {
                this.item_id = null;
                $('#delete_currency_close').trigger('click');
              }
            });
        },
    }
}
</script>
