<template>
  <app-layout>
    <template #bread-crumbs>
      <inertia-link :href="route('home')" style="text-decoration: none">
        <v-icon size="16" style="margin-top: -2px">home</v-icon>
      </inertia-link>
      <span class="text-md">
                / Configurations List
            </span>

    </template>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Configurations
      </h2>
    </template>

    <v-col cols="12">
      <!--      <v-row>-->
      <!--        <v-col cols="12">-->
      <!--          <inertia-link :href="route('createConfiguration')" as="v-btn" class="float-end" small>-->
      <!--            <v-icon>add</v-icon>-->
      <!--            Add Configuration-->
      <!--          </inertia-link>-->
      <!--        </v-col>-->
      <!--      </v-row>-->
      <div class="mt-3">
        <v-tabs
            v-model="tab"
            background-color="transparent"
            color="basil"
        >
          <v-tab
              v-for="(item, index) in $page.props.tabs"
              :key="index" @click="getConfiguration(item.key)"
          >
            {{ item.title }}
          </v-tab>
        </v-tabs>

        <v-row>
          <v-col cols="12">
            <inertia-link v-if="createRoute != null" :href="route(createRoute)" as="v-btn" class="float-end" small>
              <v-icon>add</v-icon>
              {{ createTitle }}
            </inertia-link>
          </v-col>
        </v-row>
        <custom-data-table
            :delete-route="deleteRoute"
            :edit-route="editRoute"
            :headers="headers"
            :items="items"
        >
        </custom-data-table>


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
  props: ['tabs', 'errors'],
  mounted() {
    this.getConfiguration(this.$page.props.default_tab)
  },
  data() {
    return {
      item_id: null,
      drawer: null,
      tab: null,
      items: [],
      headers: [],
      editRoute: null,
      deleteRoute: null,
      createTitle: null,
      createRoute: null,
    }
  },

  methods: {
    submit() {
      this.form
          .transform(data => ({
            ...data,
            remember: this.form.remember ? 'on' : ''
          }))
          .post(this.route('login'), {
            onFinish: () => this.form.reset('password'),
          })
    },
    remove() {
      this.$inertia.post(route('deleteConfiguration'), {
        id: this.item_id
      }, {
        onFinish: () => this.item_id = null
      });
    },
    getConfiguration(title) {
      let _route = route('viewConfiguration', [title]);
      axios.get(_route)
          .then(response => {
            this.items = response.data.items;
            this.headers = response.data.headers;
            this.editRoute = response.data.edit_route;
            this.deleteRoute = response.data.delete_route;
            this.createRoute = response.data.create_route;
            this.createTitle = response.data.create_title;
            console.log(response.data);
          })
          .catch(error => {
            // this.errors = error.response?.data?.errors
            console.log(error.response)
          });
    }
  }
}
</script>
