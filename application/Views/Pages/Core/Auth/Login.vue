<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-row justify="center">
                  <v-col cols="12" sm="8" md="6" lg="5">
                    <v-card class="elevation-12 align-center" >
                      <v-toolbar dark color="primary">
                        <v-toolbar-title>Login</v-toolbar-title>
                      </v-toolbar>
                      <v-card-text>
                        <v-form>
                          <v-text-field hide-details="auto" :error="checkErrors('email')" :error-messages="errors.email"
                                        prepend-icon="account_circle" name="login" label="Login" type="text" v-model="form.email"></v-text-field>

                          <v-text-field hide-details="auto" :error="checkErrors('password')" :error-messages="errors.password"
                                        id="password" prepend-icon="lock" name="password" label="Password" type="password" v-model="form.password"></v-text-field>
                        </v-form>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="submit">Login</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
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
                    ... data,
                    remember: this.form.remember ? 'on' : ''
                }))
                .post(this.route('login'), {
                    onFinish: () => {
                        console.log(this.errors)
                        this.form.reset('password')
                    },
                })
        },
        checkErrors(key) {
            return this.errors[key] !== undefined;
        }
    }
}
</script>
