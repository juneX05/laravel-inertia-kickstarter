<template>
  <v-select
      v-model="form[field]"
      :chips="chips"
      :error="errors[field] !== undefined"
      :error-messages="errors[field]"
      :hint="hint"
      :placeholder="placeholder"
      :item-text="item_name"
      :item-value="item_id"
      :items="items"
      :label="label"
      :multiple="multiple"
      :no-data-text="label"
      :small-chips="chips"
      class="mb-3"
      clearable
      dense
      outlined
      persistent-hint
      single-line
  ></v-select>
</template>

<script>

export default {
  components: {},
  props: {
    'errors': Object,
    'hint': String,
    'placeholder': String,
    'form': Object,
    'label': String,
    'field': String,
    'items': Array,
    'item_name': String | Function,
    'item_id': String,
    chips: {
      type: Boolean,
      default: false
    },
    multiple: {
      type: Boolean,
      default: false
    },
  },
  data() {
    return {}
  },
}
</script>

