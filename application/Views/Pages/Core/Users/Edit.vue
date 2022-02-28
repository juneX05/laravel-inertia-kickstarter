<template>
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">
        Edit User {{ data.name }}
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
    </div>

    <div class="card-footer">
      <button class="btn btn-primary" @click="submit">
        Update User
      </button>
    </div>

  </div>
</template>

<script>

export default {
  name:'EditUser',
    components: {

    },
    props: ['errors', 'data'],
    mounted() {
        console.log(this.data)
    },
    data() {
        return {
            drawer: null,
            // form: this.user,
            form: this.$inertia.form({
                id: this.data.id,
                name: this.data.name,
                email: this.data.email
            }),
            loading: false
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.form
                .transform(data => ({
                    ...data,
                }))
                .post(this.route('updateUser'), {
                    onSuccess: () => {
                        console.log('User Updated Successfully')
                    },
                    onError: () => {
                        console.log(this.errors)
                    },
                    onFinish: () => {
                        this.loading = false;
                    },
                })
        }
        ,
        checkErrors(key) {
            return this.errors[key] !== undefined;
        }
    }
}
</script>
