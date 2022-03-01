<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Menus
      </h2>
    </template>

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">
          Edit Menu
        </h3>
        <div class="card-tools">

        </div>
      </div>
      <div class="row">
        <div class="card-body col-sm-12">
          <div class="row">
            <text-input
                :form="form"
                :label="'Name'"
                :field="'name'"
                :type="'text'"
                :classes="'col-sm-6'"
                :errors="errors"
                :placeholder="'Menu name should not contain any spaces'"
            ></text-input>

            <text-input
                :form="form"
                :label="'Title'"
                :field="'title'"
                :type="'text'"
                :classes="'col-sm-6'"
                :errors="errors"
                :placeholder="'Menu Title'"
            ></text-input>

            <text-input
                :form="form"
                :label="'Icon'"
                :field="'icon'"
                :type="'text'"
                :classes="'col-sm-6'"
                :errors="errors"
                :placeholder="'Font Awesome Icon ex. fa-wrench'"
            ></text-input>

            <text-input
                :form="form"
                :label="'Route Name/ Link'"
                :field="'link'"
                :type="'text'"
                :classes="'col-sm-6'"
                :errors="errors"
                :placeholder="'Route Name or Link'"
            ></text-input>

            <select-input
                :form="form"
                :label="'Menu Type'"
                :field="'menu_type'"
                :classes="'col-sm-6'"
                :errors="errors"
                :placeholder="'Menu Type'"
                :items="menu_types"
                :item_id="'id'"
                :item_name="'name'"
            ></select-input>

            <select-input
                v-if="form.menu_type === 'module_menu'"
                :form="form"
                :label="'Module Group'"
                :field="'module_group'"
                :classes="'col-sm-6'"
                :errors="errors"
                :placeholder="'Module Groups'"
                :items="module_groups"
                :item_id="'id'"
                :item_name="'name'"
            ></select-input>

            <select-input
                v-if="form.menu_type === 'module_menu'"
                :form="form"
                :label="'Module'"
                :field="'module'"
                :classes="'col-sm-6'"
                :errors="errors"
                :placeholder="'Module'"
                :items="modules"
                :item_id="'name'"
                :item_name="'name'"
            ></select-input>

            <select-input
                :form="form"
                :label="'Parent'"
                :field="'parent'"
                :classes="'col-sm-6'"
                :errors="errors"
                :placeholder="'Parent'"
                :items="menus"
                :item_id="'id'"
                :item_name="'title'"
            ></select-input>

          </div>
        </div>
      </div>

    </div>

    <div class="card card-primary collapsed-card">
      <div class="card-header">
        <h3 class="card-title">
          Permissions
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body col-sm-12">
        <div class="form-group">

          <div v-if="errors['permissions']" :id="'permissions' + '-error'"
               class="error text-center text-red mb-2">
            {{ errors['permissions'] }}
          </div>

          <div class="row">
            <div class="col-sm-6" v-for="(permission, index) in permissions" :key="index">
              <div class="icheck-primary">
                <input type="checkbox" :id="'permission' + index" :value="permission.name"
                       :name="permission.name + 'checkbox'" v-model="form.permissions" :key="'input'+index">
                <label :for="'permission' + index">
                  {{ permission.title }}
                </label>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

    <div class="card">
      <div class="card-footer">
        <button class="btn btn-primary" @click="submit">
          Update Menu
        </button>
      </div>
    </div>

  </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import textInput from "@/Theme/Components/textInput";
import menuForm from "@/Pages/Core/Menus/menuForm";
import SelectInput from "../../../Theme/Components/selectInput";

export default {
  components: {
    SelectInput,
    menuForm,
    textInput,
    AppLayout,
  },
  props: [
    'errors','menu','core_modules', 'system_modules', 'permissions', 'menu_types', 'module_groups', 'link_types', 'menus'
  ],
  data() {
    return {
      drawer: null,
      form: {
        key_id: this.menu.name,
        title: this.menu.title,
        name: this.menu.name,
        menu_type: this.menu.menu_type,
        permissions: this.menu.permissions,
        module_group: this.menu.module_group,
        module: this.menu.module,
        link: this.menu.link,
        icon: this.menu.icon,
        parent: this.menu.parent,
        position: this.menu.position,
      },
      loading:false,
      modules: this.menu.module_group === 'core'? this.core_modules : this.system_modules
    }
  },
  updated() {
    $('.select2').select2();
    $('.select2').on("select2:select", (e) => {
      const id = $(e.currentTarget).attr('id');
      const value = $(e.currentTarget).val();
      this.form[id] = value;

      console.log(value);

      if (id === 'module_group') {
        $('.select2#module').val('');
        $('.select2#module').select2('destroy');
        console.log(value);
        if (value === 'core') this.modules = this.core_modules;
        else if (value === 'system') this.modules = this.system_modules;
        else this.modules = [];
        $('.select2#module').select2();
      }
    });
  },
  methods: {
    submit() {
      this.loading = true;
      this.$inertia.form(this.form)
          .transform(data => ({
            ... data,
          }))
          .post(this.route('updateMenu'), {
            onSuccess: () => {
              console.log('success');
              this.$inertia.visit(route('viewMenus'))
            },
            onError: () => {
              console.log(this.errors)
            },
            onFinish: () => {
              this.loading = false;
            },
          })
    },
    checkErrors(key) {
      return this.errors[key] !== undefined;
    }
  }
}
</script>
