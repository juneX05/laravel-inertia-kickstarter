<template>
    <app-layout>
        <template #bread-crumbs>
            <inertia-link :href="route('home')" style="text-decoration: none">
                <v-icon size="16" style="margin-top: -2px">home</v-icon>
            </inertia-link>
            /
            <inertia-link :href="route('viewCurrencies')" style="text-decoration: none">
                Currencies List
            </inertia-link>
            <span class="text-md">
                / Create Currency
            </span>

            <br/>
            <inertia-link :href="route('viewCurrencies')" as="v-btn" class="mt-2" small style="text-decoration: none">
                <v-icon>arrow_back</v-icon>
                Back
            </inertia-link>
        </template>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Currencies
            </h2>
        </template>

        <v-row align="center" align-content="center" justify="center">
            <v-col cols="8">
                <v-card class="mt-2">
                    <v-card-title>
                        Create New Currency
                    </v-card-title>
                    <v-card-text class="pb-0">
                        <currency-form
                          :errors="errors"
                          :form="form"
                        ></currency-form>
                    </v-card-text>
                    <v-card-actions class="pt-0">
                        <v-btn :loading="loading" dark @click="submit">Save Currency</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

        </v-row>

    </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import CurrencyForm from "@/Configurations/SysConfigs/Tabs/Currencies/Views/currencyForm";

export default {
    components: {
      CurrencyForm,
        AppLayout,
    },
    props: ['errors'],
    data() {
        return {
            drawer: null,
            form: this.$inertia.form({
                name: '',
                abbreviation: '',
                symbol: '',
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
                .post(this.route('saveCurrency'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewCurrencies'))
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
