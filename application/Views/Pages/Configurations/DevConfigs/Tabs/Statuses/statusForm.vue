<template>
  <form>
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
        :field="'id'"
        :form="form"
        :hint="'Status ID'"
        :label="'Status ID'"
        :type="'number'"
    ></textInput>
    <textInput
        :errors="errors"
        :field="'color'"
        :form="form"
        :hint="'Status Color'"
        :label="'Status Color'"
        :type="'text'"
    ></textInput>
  </form>
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

    }
  }
}
</script>
