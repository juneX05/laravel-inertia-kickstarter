<template>
  <v-form>
    <textInput
        :errors="errors"
        :field="'title'"
        :form="form"
        :hint="'Menu Title is the text that will represent your menu on the side bar'"
        :label="'Menu Title'"
        :type="'text'"
    ></textInput>
    <textInput
        :errors="errors"
        :field="'id'"
        :form="form"
        :hint="'Menu ID is used to distinguish the menu from other menus. It should be unique to avoid collision with other menus.'"
        :label="'Menu Id'"
        :type="'text'"
    ></textInput>
    <selectInput
        :errors="errors"
        :field="'link_type'"
        :form="form"
        :hint="'Select the type of link.'"
        :item_id="'value'"
        :item_name="'text'"
        :items="link_type_items"
        :label="'Link Type'"
    ></selectInput>
    <textInput
        :errors="errors"
        :field="'link'"
        :form="form"
        :hint="'Enter the link you want.'"
        :label="'Link'"
        :type="'text'"
    ></textInput>
    <selectInput
        :errors="errors"
        :field="'route'"
        :form="form"
        :hint="'Select the route.'"
        :item_id="'uri'"
        :item_name="'uri'"
        :items="routes"
        :label="'Route'"
    ></selectInput>
    <selectInput
        :errors="errors"
        :field="'menu_type'"
        :form="form"
        :hint="'Select the type of menu.'"
        :item_id="'value'"
        :item_name="'text'"
        :items="menu_type_items"
        :label="'Menu Type'"
    ></selectInput>
    <selectInput
        :errors="errors"
        :field="'module_group'"
        :form="form"
        :hint="'Select the module group.'"
        :item_id="'value'"
        :item_name="'text'"
        :items="module_group_items"
        :label="'Module Group'"
    ></selectInput>
    <selectInput
        :errors="errors"
        :field="'module'"
        :form="form"
        :hint="'Select the module.'"
        :item_id="'value'"
        :item_name="'text'"
        :items="form['module_group'] === 'core' ? core_modules : system_modules"
        :label="'Module'"
    ></selectInput>
    <selectInput
        :errors="errors"
        :field="'parent'"
        :form="form"
        :hint="'Select the parent Menu.'"
        :item_id="'id'"
        :item_name="'title'"
        :items="menus"
        :label="'Parent Menu'"
    ></selectInput>
    <selectInput
        :chips="true"
        :errors="errors"
        :field="'permissions'"
        :form="form"
        :hint="'Select the menu permissions.'"
        :item_id="'name'"
        :item_name="'name'"
        :items="permissions"
        :label="'Menu Permission'"
        :multiple="true"
    ></selectInput>
  </v-form>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import textInput from "@/Theme/Components/textInput";
import selectInput from "@/Theme/Components/selectInput";

export default {
  components: {
    selectInput,
    textInput,
    AppLayout,
  },
  props: [
      'errors','form','menu_type_items', 'module_group_items','core_modules','system_modules',
    'menus', 'permissions', 'link_type_items', 'routes'
  ],
}
</script>
