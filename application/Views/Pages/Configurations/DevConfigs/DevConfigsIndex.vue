<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dev Configs
      </h2>
    </template>

    <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
          <li class="nav-item">
            <inertia-link class="nav-link active" :href="route('viewStatuses')"
                          id="custom-tabs-four-home-tab" data-toggle="pill"
                          role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">
              <i class="fa fa-plus "></i>
              Statuses
            </inertia-link>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
          <slot></slot>
        </div>
      </div>
      <!-- /.card -->
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
  }
}
</script>
