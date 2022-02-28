<template>
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">
        Manage User {{ data.name }}
      </h3>
      <div class="card-tools">

      </div>
    </div>
    <div class="card-body">
      <div class="row" style="height: 50vh; overflow-y: auto">
        <div class="col-md-12" v-for="(permission, index) in permissions" :key="index">
          <div class="icheck-primary">
            <input type="checkbox" :id="'permission' + index" :value="permission.name"
                   :name="permission.name + 'checkbox'" v-model="permission_names" :key="'input'+index">
            <label :for="'permission' + index">
              {{ permission.name }}
            </label>
          </div>

        </div>
      </div>
    </div>

    <div class="card-footer">
      <button class="btn btn-primary" @click="submit">
        Update User Permissions
      </button>
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
        submit() {
            this.loading = true;
            this.form
                .transform(data => ({
                    ... data,
                    permission_names: this.permission_names
                }))
                .post(this.route('saveUserPermissions'), {
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        console.log(this.errors)
                    },
                    onFinish: () => {
                        this.loading = false;
                        this.$inertia.visit('/users')
                    },
                })
        }
    }
}
</script>
