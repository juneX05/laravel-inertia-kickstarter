<template>
  <v-menu
      ref="menu1"
      v-model="menu1"
      :close-on-content-click="false"
      max-width="290px"
      min-width="auto"
      offset-y
      transition="scale-transition"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
          v-model="form[field]"
          v-bind="attrs"
          v-on="on"
          :error="errors[field] !== undefined"
          :error-messages="errors[field]"
          :hint="hint"
          :label="label"
          :name="field"
          :disabled="disabled"
          class="mb-3"
          dense
          hide-details="auto"
          outlined
          persistent-hint
          @blur="date = parseDate(form[field])"
      ></v-text-field>
    </template>
    <v-date-picker
        v-model="date"
        no-title
        @input="menu1 = false"
    ></v-date-picker>
  </v-menu>
</template>

<script>
export default {
  props: {
    initial_date: {
      type: String,
      default: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)
    },
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
    date: vm.initial_date,
    menu1: false,
    menu2: false,
  }),

  computed: {
    computedDateFormatted() {
      return this.formatDate(this.date)
    },
  },

  watch: {
    date(val) {
      this.form[this.field] = this.formatDate(this.date)
    },
  },

  methods: {
    formatDate(date) {
      if (!date) return null

      const [year, month, day] = date.split('-')
      return `${day}-${month}-${year}`
    },
    parseDate(date) {
      if (!date) return null

      const [day, month, year] = date.split('/')
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
    },
  },
}
</script>

<style scoped>

</style>