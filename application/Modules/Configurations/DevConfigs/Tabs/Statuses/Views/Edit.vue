<template>
    <app-layout>
      <template #bread-crumbs>
        <inertia-link :href="route('home')" style="text-decoration: none">
          <v-icon size="16" style="margin-top: -2px">home</v-icon>
        </inertia-link>
        /
        <inertia-link :href="route('viewStatuses')" style="text-decoration: none">
          Statuses List
        </inertia-link>
        <span class="text-md">
                / Edit Status
            </span>

        <br/>
        <inertia-link :href="route('viewStatuses')" as="v-btn" class="mt-2" small style="text-decoration: none">
          <v-icon>arrow_back</v-icon>
          Back
        </inertia-link>
      </template>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Statuses
        </h2>
      </template>

        <v-row align="center" align-content="center" justify="center">
            <v-col cols="8">
                <v-card class="mt-2">
                    <v-card-title>
                        EDIT Status
                    </v-card-title>
                    <v-card-text class="pb-0">
                        <status-form
                          :errors="errors"
                          :form="form"
                        ></status-form>
                    </v-card-text>
                    <v-card-actions class="pt-0">
                        <v-btn :loading="loading" dark @click="submit">Update Status</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

        </v-row>

    </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import StatusForm from "@/Configurations/DevConfigs/Tabs/Statuses/Views/statusForm";

export default {
    components: {
      StatusForm,
        AppLayout,
    },
    props: ['errors','status'],
    mounted() {
        console.log(this.status)
    },
    data() {
        return {
            drawer: null,
            // form: this.permission,
            form: this.$inertia.form({
                id:this.status.id,
                name:this.status.name,
                abbreviation:this.status.abbreviation,
                symbol:this.status.symbol,
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
                .post(this.route('updateStatus'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewStatuses'))
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
