<template>
  <v-form>
    <textInput
        :errors="errors"
        :field="'name'"
        :form="form"
        :hint="'Enter Status Name'"
        :label="'Status Name'"
        :type="'text'"
    ></textInput>
    <textInput
        :errors="errors"
        :field="'abbreviation'"
        :form="form"
        :hint="'Status Abbreviation'"
        :label="'Status Abbreviation'"
        :type="'text'"
    ></textInput>
    <textInput
        :errors="errors"
        :field="'symbol'"
        :form="form"
        :hint="'Status Symbol'"
        :label="'Status Symbol'"
        :type="'text'"
    ></textInput>
  </v-form>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import textInput from "@/Theme/Components/textInput";
import textAreaInput from "@/Theme/Components/textAreaInput";
import selectInput from "@/Theme/Components/selectInput";
import fileUpload from "@/Theme/Components/fileUpload";

export default {
  components: {
    fileUpload,
    selectInput,
    textAreaInput,
    textInput,
    AppLayout,
  },
  props: ['errors','form'],
  data() {
    return {
      room_types: [],
      room_categories: [],
      room_amenities: [],
    }
  }
}
</script>
