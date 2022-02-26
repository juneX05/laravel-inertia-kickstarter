<template>
  <v-textarea v-model="form[field]"
              :error="errors[field] !== undefined"
              :error-messages="errors[field]"
              :hint="hint"
              :label="label"
              :name="field"
              :rows="rows"
              class="mb-3"
              dense
              hide-details="auto"
              outlined
              persistent-hint></v-textarea>
</template>

<script>

export default {
  components: {},
  props: ['errors', 'hint', 'form', 'label', 'field', 'rows'],
  data() {
    return {}
  },
}
</script>
