<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            New User
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
            <label for="email"> Email</label>
            <input type="text" id="email" v-model="form.email" class="form-control">
          </div>
          <div class="form-group">
            <label for="password"> Password</label>
            <input type="text" id="password" v-model="form.password" class="form-control">
          </div>
          <div class="form-group">
            <label for="confirm_password"> Confirm Password</label>
            <input type="text" id="confirm_password" v-model="form.password_confirmation" class="form-control">
          </div>
        </div>

        <div class="card-footer">
          <button class="btn btn-primary" @click="submit">
            Save User
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
                email: '',
                password: '',
                password_confirmation: '',
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
                .post(this.route('saveUser'), {
                    onSuccess: () => {
                        this.$inertia.visit('/users')
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
