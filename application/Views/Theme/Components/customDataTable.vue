<template>
  <v-data-table v-if="items.length > 0"
                :headers="headers"
                :items.sync="items"
                class="elevation-1 mt-3"
                item-key="id"
                @pagination="(event) => this.page_start = event.pageStart"
  >
    <template v-slot:item.SNO="{ item, index }">
      {{ index + 1 + page_start }}
    </template>
    <template v-slot:item.actions="{ item }">
      <div v-if="item_id == null  && editRoute != null">
        <inertia-link :href="route(editRoute, [item.id])" as="v-icon" class="mr-2" small>
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

          <v-btn dark small @click="item_id = null">No</v-btn>
          <v-spacer></v-spacer>
          <v-btn small @click="remove">I'm Sure</v-btn>
        </v-row>
      </div>
    </template>
  </v-data-table>
  <v-card v-else class="mt-3">
    <v-card-text>
      <v-icon>warning</v-icon>
      <p>
        No Data Available for this table
      </p>
    </v-card-text>
  </v-card>
</template>

<script>

export default {
  props: {
    items: {
      type: Array,
      required: true
    },
    headers: {
      type: Array,
      required: true
    },
    customColumns: {
      type: Array
    },
    editRoute: {
      type: String,
      default: null
    },
    deleteRoute: {
      type: String,
      default: null
    },
  },
  data() {
    return {
      item_id: null,
      page_start: null,
    }
  },

  methods: {
    remove() {
      if (this.deleteRoute == null) {
        return;
      }
      this.$inertia.post(route(this.deleteRoute), {
        id: this.item_id
      }, {
        onFinish: () => this.item_id = null
      });
    },
  }
}
</script>
