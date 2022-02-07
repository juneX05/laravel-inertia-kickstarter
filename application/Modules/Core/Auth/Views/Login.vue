<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          <form @submit.prevent="submit" method="post">
            <div class="input-group mb-3">
              <input type="email"
                     v-model="form.email"
                     class="form-control"
                     :class="checkErrors('email')? 'is-invalid' : ''"
                     placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
              <span v-if="checkErrors('email')"
                    id="exampleInputEmail1-error"
                    class="error invalid-feedback"
              >
                {{ errors.email }}
              </span>
            </div>
            <div class="input-group mb-3">
              <input
                  type="password"
                  :class="checkErrors('password')? 'is-invalid' : ''"
                  v-model="form.password"
                  class="form-control"
                  placeholder="Password"
              >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
              <span v-if="checkErrors('password')"
                    id="exampleInputPassword1-error"
                    class="error invalid-feedback"
              >
                {{ errors.password }}
              </span>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->
  </div>
</template>

<script>
export default {
  props: {
    errors: Object,
    source: String,
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  },

  data() {
    return {
      drawer: null,
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false
      })
    }
  },

  methods: {
    submit() {
      this.form
          .transform(data => ({
            ...data,
            remember: this.form.remember ? 'on' : ''
          }))
          .post(this.route('login'), {
            onFinish: () => {
              console.log(this.errors)
              this.form.reset('password')
              window.location.reload();
            },
          })
    },
    checkErrors(key) {
      return this.errors[key] !== undefined;
    }
  }
}
</script>
