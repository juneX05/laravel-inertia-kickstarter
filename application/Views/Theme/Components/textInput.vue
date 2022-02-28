<template>
  <div :class="'form-group ' + classes">
    <label :for="field">
      {{ label }}
    </label>
    <input :type="type"
           :id="field"
           v-model="form[field]" class="form-control form-control-sm "
           :placeholder="placeholder"
    >
    <span v-if="errors[field]" :id="field + '-error'" class="error text-red">
      {{ errors[field] }}
    </span>
  </div>
</template>

<script>

export default {
  components: {},
  props: ['errors','placeholder','form','label','field','type', 'classes',],
  data() {
    return {}
  },
}
</script>
