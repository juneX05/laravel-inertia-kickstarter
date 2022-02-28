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
            New Permission
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
            Save Permission
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
    props: ['errors'],
    data() {
        return {
            drawer: null,
            form: this.$inertia.form({
                name: '',
                title: '',
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
                .post(this.route('savePermission'), {
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
