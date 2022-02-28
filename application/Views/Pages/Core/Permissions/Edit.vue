<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Permissions
      </h2>
    </template>

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">
          Edit Permission
        </h3>
        <div class="card-tools">

        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="name"> Name</label>
          <input type="text" id="name" v-model="form.name" class="form-control">
        </div>
        <div class="form-group">
          <label for="title"> Title</label>
          <input type="text" id="title" v-model="form.title" class="form-control">
        </div>
      </div>

      <div class="card-footer">
        <button class="btn btn-primary" @click="submit">
          Update Permission
        </button>
      </div>

    </div>

  </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'

export default {
    components: {
        AppLayout,
    },
    props: ['errors','permission'],
    mounted() {
        console.log(this.permission)
    },
    data() {
        return {
            drawer: null,
            // form: this.permission,
            form: this.$inertia.form({
                id:this.permission.id,
                name:this.permission.name,
                title:this.permission.title
            }),
            loading:false
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.form
                .transform(data => ({
                    ... data,
                }))
                .post(this.route('updatePermission'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewPermissions'))
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
