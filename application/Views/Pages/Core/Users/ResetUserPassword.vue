<template>
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">
        Manage Password For User {{ user_name }}
      </h3>
      <div class="card-tools">

      </div>
    </div>
    <div class="card-body">
      <p class="text-red">
        (Note this action should be used in emergency cases).
      </p>
      <div class="form-group">
        <label for="password"> Password</label>
        <input type="password" id="password" v-model="form.password" class="form-control">
      </div>
      <div class="form-group">
        <label for="confirm_password"> Confirm Password</label>
        <input type="password" id="confirm_password" v-model="form.password_confirmation" class="form-control">
      </div>
    </div>

    <div class="card-footer">
      <button class="btn btn-primary" @click="submit">
        Update Password
      </button>
    </div>

  </div>
</template>

<script>
export default {
    name: "ResetUserPassword",
    props: ['user_id','user_name'],
    data() {
        return {
            form: this.$inertia.form({
                id: this.user_id,
                password: '',
                password_confirmation: '',
            }),
            errors: {}
        }
    },

    methods: {
        submit() {
            this.form.post(route('resetUserPassword'), {
                errorBag: 'resetUserPassword',
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset();
                    this.errors = {}
                },
                onError: () => {
                    this.errors = this.form.errors;
                }
            })
        },
        checkErrors(key) {
            return this.errors[key] !== undefined;
        }

    },

}
</script>

<style scoped>

</style>
