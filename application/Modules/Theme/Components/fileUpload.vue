<template>
  <v-file-input
      v-model="form[field]"
      :accept="allowed_files"
      :error="errors[field] !== undefined"
      :error-messages="errors[field]"
      :hint="hint"
      :label="label"
      :multiple="multiple"
      :placeholder="placeholder"
      color="deep-purple accent-4"
      counter
      dense
      outlined
      persistent-hint
      :prepend-icon="prepend_icon"
  >
    <template v-slot:selection="{ index, text }">
      <v-chip
          color="deep-purple accent-4"
          dark
          label
          small
      >
        {{ text }}
      </v-chip>

<!--      <span-->
<!--          v-else-if="index === 2"-->
<!--          class="text-overline grey&#45;&#45;text text&#45;&#45;darken-3 mx-2"-->
<!--      >-->
<!--        +{{ files.length - 2 }} File(s)-->
<!--      </span>-->
    </template>
  </v-file-input>
</template>


<script>

export default {
  components: {},
  props: {
    'errors':Object,
    'placeholder': String,
    'hint': String,
    'form': Object,
    'label': String,
    'field': String,
    'allowed_files': String,
    multiple: {
      type: Boolean,
      default: false
    },
    prepend_icon: {
      type: String,
      default: 'mdi-paperclip'
    }
  },
  data() {
    return {}
  },
}
</script>

