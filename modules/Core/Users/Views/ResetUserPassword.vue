<template>
    <v-row>
        <v-col cols="12">
            <v-card>
                <v-card-title>
                    Reset User Password
                </v-card-title>
                <v-card-subtitle class="red--text">
                    (Note this action should be used in emergency cases).
                </v-card-subtitle>
                <v-card-text>
                    <v-form>
                        <v-text-field class="mb-2"
                            hide-details="auto" :error="checkErrors('password')" :error-messages="errors.password" persistent-hint
                            outlined dense label="New Password" name="new_password" type="password" v-model="form.password"></v-text-field>
                        <v-text-field class="mb-2"
                            hide-details="auto" :error="checkErrors('new_password')" :error-messages="errors.new_password" persistent-hint
                            outlined dense label="Repeat New Password" name="password_confirmation" type="password" v-model="form.password_confirmation"></v-text-field>
                    </v-form>
                    <v-btn dark @click="updatePassword">
                        Reset Password
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "ResetUserPassword",
    props: ['user_id'],
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
        updatePassword() {
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
