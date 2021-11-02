<template>
    <v-row>
        <v-col cols="12">
            <v-card>
                <v-card-title>
                    Update Profile Information
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-text-field class="mb-3"
                            hide-details="auto" :error="checkErrors('name')" :error-messages="formErrors.name"
                            outlined dense label="User Name" name="name" type="text" v-model="form.name"></v-text-field>

                        <v-text-field class="mb-3"
                            hide-details="auto" :error="checkErrors('email')" :error-messages="formErrors.email"
                            outlined dense label="User Email" name="email" type="email" v-model="form.email"></v-text-field>
                    </v-form>
                    <v-btn dark @click="updateProfileInformation">
                        Update
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import AppLayout from "@/Theme/Layouts/AppLayout";
export default {
    name: "UpdateProfileInformation",
    props: ['errors','user'],
    components: {AppLayout},
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.user.name,
                email: this.user.email,
            }),
            formErrors: {}
        }
    },
    methods : {
        updateProfileInformation() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }

            this.form.post(route('user-profile-information.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
                onSuccess: () => {
                    this.formErrors = {};
                },
                onError: () => {
                    this.formErrors = this.errors['updateProfileInformation'];
                },
                onFinish: () => {
                    console.log('finished')
                },
            });
        },
        checkErrors(key) {
            return this.formErrors[key] !== undefined;
        }
    }
}
</script>

<style scoped>

</style>
