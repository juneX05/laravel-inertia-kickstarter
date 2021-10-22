<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Profile
            </h2>
        </template>
        <template #bread-crumbs>
            <inertia-link href="/" style="text-decoration: none">
                <v-icon size="16" style="margin-top: -2px">home</v-icon>
            </inertia-link>
            <span class="text-md">
                / User Profile
            </span>
        </template>

        <update-profile-information :user="$page.props.user" :errors="$page.props.errors" />

        <update-password :errors="$page.props.errors"/>

    </app-layout>
</template>

<script>
import AppLayout from "@/Theme/Layouts/AppLayout";
import UpdateProfileInformation from "./UpdateProfileInformation";
import UpdatePassword from "./UpdatePassword";
export default {
    name: "Profile",
    components: {UpdatePassword, UpdateProfileInformation, AppLayout},
}
</script>

<style scoped>

</style>
