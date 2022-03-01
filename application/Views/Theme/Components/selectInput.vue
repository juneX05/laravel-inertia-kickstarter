<template>
  <div :class="'form-group ' + classes">
    <label :for="field">
      {{ label }}
    </label>
    <select class="form-control select2" v-model="form[field]"
            :id="field" style="width: 100%;" :multiple="multiple">
      <option value="" selected="selected">-- Select {{ label }} --</option>
      <option :value="item[item_id]" v-for="(item, index) in items" :key="index">
        {{ item[item_name] }}
      </option>
    </select>
    <span v-if="errors[field]" :id="field + '-error'" class="error text-red">
      {{ errors[field] }}
    </span>
  </div>
</template>

<script>

export default {
  components: {},
  props: {
    errors: Object,
    placeholder: String,
    form: Object,
    label: String,
    field: String,
    items: Array,
    item_name: String | Function,
    item_id: String,
    classes: String,
    multiple: {
      type: Boolean,
      default: false
    },
  },
  mounted() {
    $('.select2').select2();
  },
  data() {
    return {}
  },
}
</script>

<style>

</style>
