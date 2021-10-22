<template>
    <app-layout>
        <template #bread-crumbs>
            <inertia-link href="/" style="text-decoration: none">
                <v-icon size="16" style="margin-top: -2px">home</v-icon>
            </inertia-link>
            <span class="text-md">
                / Dashboard
            </span>

        </template>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <v-btn>
            Welcome to the biggest dashboard of your life
        </v-btn>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Theme/Layouts/AppLayout'

    export default {

        props: ['data', 'errors'],
        components: {
            AppLayout,
        },
    }
</script>
