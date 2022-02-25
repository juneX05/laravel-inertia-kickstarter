<template>
    <v-row>
        <v-col cols="12">
            <v-card>
                <v-card-title>
                    Update Password
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-text-field class="mb-3"
                            hide-details="auto" :error="checkErrors('current_password')" :error-messages="formErrors.current_password"
                            outlined dense label="Current Password" name="current_password" type="password" v-model="form.current_password"></v-text-field>
                        <v-text-field class="mb-3"
                            hide-details="auto" :error="checkErrors('password')" :error-messages="formErrors.password"
                            outlined dense label="New Password" name="new_password" type="password" v-model="form.password"></v-text-field>
                        <v-text-field class="mb-3"
                            hide-details="auto" :error="checkErrors('password')" :error-messages="formErrors.password"
                            outlined dense label="Repeat New Password" name="password_confirmation" type="password" v-model="form.password_confirmation"></v-text-field>
                    </v-form>
                    <v-btn dark @click="updatePassword">
                        Change Password
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "UpdatePassword",
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
        updatePassword() {
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
