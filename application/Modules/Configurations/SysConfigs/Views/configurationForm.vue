<template>
  <v-form>
    <v-row>
      <v-col cols="12" lg="6" md="6" sm="6">
        <textInput
            :errors="errors"
            :field="'name'"
            :form="form"
            :hint="'Enter Configuration Name'"
            :label="'Configuration Name'"
            :type="'text'"
        ></textInput>

        <textInput
            :errors="errors"
            :field="'number'"
            :form="form"
            :hint="'Enter Configuration Number'"
            :label="'Configuration Number'"
            :type="'text'"
        ></textInput>

        <textAreaInput
            :errors="errors"
            :field="'description'"
            :form="form"
            :hint="'Enter Configuration Description'"
            :label="'Configuration Description'"
            :rows="4"
            :type="'text'"
        ></textAreaInput>

      </v-col>

      <v-col cols="12" lg="6" md="6" sm="6">


        <selectInput
            :errors="errors"
            :field="'configuration_category_id'"
            :form="form"
            :hint=" 'Select Configuration Category' "
            :item_id="'id'"
            :item_name="'name'"
            :items="configuration_categories"
            :label="'Select Configuration Category'"
        ></selectInput>

        <selectInput
            :errors="errors"
            :field="'configuration_type_id'"
            :form="form"
            :hint=" 'Select Configuration Type' "
            :item_id="'id'"
            :item_name="'name'"
            :items="configuration_types"
            :label="'Select Configuration Type'"
        ></selectInput>

        <selectInput
            :chips="true"
            :errors="errors"
            :field="'configuration_amenities'"
            :form="form"
            :hint=" 'Select Configuration Amenities' "
            :item_id="'id'"
            :item_name="'name'"
            :items="amenities"
            :label="'Configuration Amenities'"
            :multiple="true"
        ></selectInput>

        <fileUpload
            :allowed_files="'image/*'"
            :errors="errors"
            :field="'configuration_images'"
            :form="form"
            :hint="'Upload Configuration Images'"
            :label="'Configuration Images'"
            :multiple="true"
            :placeholder="'Configuration Images'"
        ></fileUpload>

      </v-col>
    </v-row>

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
  props: {
    'errors': Object,
    'form': Object,
    'configuration_types': Array,
    'configuration_categories': Array,
    'amenities': Array,
  },
  data() {
    return {}
  }
}
</script>
