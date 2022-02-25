<template>
  <v-text-field v-model="form[field]"
                :error="errors[field] !== undefined"
                :error-messages="errors[field]"
                :hint="hint"
                :label="label"
                :name="field"
                :type="type"
                class="mb-3"
                dense
                hide-details="auto"
                outlined
                persistent-hint></v-text-field>
</template>

<script>

export default {
  components: {
  },
  props: ['errors','hint','form','label','field','type'],
  data() {
    return {
    }
  },
}
</script>
