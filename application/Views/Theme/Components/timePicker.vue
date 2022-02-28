<template>
  <v-menu
      ref="menu"
      v-model="menu2"
      :close-on-content-click="false"
      :nudge-right="40"
      :return-value.sync="form[field]"
      min-width="290px"
      offset-y
      transition="scale-transition"
  >
    <template v-slot:activator="{ on, attrs }">

      <!--      prepend-icon="mdi-clock-time-four-outline"-->
      <v-text-field
          v-model="form[field]"
          v-bind="attrs"
          v-on="on"
          :label="label"
          class="mb-3"
          dense
          hide-details="auto"
          outlined
          persistent-hint
          readonly
      ></v-text-field>
    </template>
    <v-time-picker
        v-if="menu2"
        v-model="form[field]"
        full-width
        @click:minute="$refs.menu.save(form[field])"
    ></v-time-picker>
  </v-menu>
</template>

<script>
export default {
  props: {
    label: String,
    'errors': Object,
    'hint': String,
    'form': Object,
    'field': String,
    disabled: {
      type: Boolean,
      default: false
    }
  },
  data: vm => ({
    menu2: false,
  }),

  computed: {},

  watch: {},

  methods: {},
}
</script>

<style scoped>

</style>