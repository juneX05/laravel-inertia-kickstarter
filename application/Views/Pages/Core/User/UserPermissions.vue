<template>
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">
        User  <b>{{ data.name }}</b>  Permissions
      </h3>
      <div class="card-tools">

      </div>
    </div>
    <div class="card-body">
      <div class="row" style="height: 50vh; overflow-y: auto">
        <div class="col-md-12" v-for="(permission, index) in permissions" :key="index">
          <div class="icheck-primary">
            <input type="checkbox" :id="'permission' + index" :value="permission.name" disabled
                   :name="permission.name + 'checkbox'" v-model="permission_names" :key="'input'+index">
            <label :for="'permission' + index">
              {{ permission.title }}
            </label>
          </div>

        </div>
      </div>
    </div>

  </div>

</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'

export default {
    components: {
        AppLayout,
    },
    props: ['data','user_permissions', 'permissions','errors'],
    mounted() {
        console.log(this.data)
    },
    data() {
        return {
            drawer: null,
            form: this.$inertia.form({
                user_id: this.data.id,
            }),
            name: this.data.name,
            loading:false,
            permission_names : this.user_permissions,
        }
    },

    methods: {
    }
}
</script>
