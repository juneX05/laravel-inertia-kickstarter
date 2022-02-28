<template>
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">
        Change Password
      </h3>
      <div class="card-tools">

      </div>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label for="password"> Password</label>
        <input type="password" id="current_password" v-model="form.current_password" class="form-control">
      </div>
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
  name: "ChangePassword",
  props:['errors'],
  data() {
    return {
      form: this.$inertia.form({
        current_password: '',
        password: '',
        password_confirmation: '',
      }),
      formErrors: {}
    }
  },

  methods: {
    submit() {
      this.form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.formErrors = {}
        },
        onError: () => {
          if (this.form.errors.password) {
            this.form.reset('password', 'password_confirmation')
            // this.$refs.password.focus()
          }

          if (this.form.errors.current_password) {
            this.form.reset('current_password')
            // this.$refs.current_password.focus()
          }
          this.formErrors = this.errors['updatePassword'];
        }
      })
    },
    checkErrors(key) {
      return this.formErrors[key] !== undefined;
    }
  },

}
</script>

<style scoped>

</style>
