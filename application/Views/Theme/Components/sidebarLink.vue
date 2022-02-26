<template>
  <inertia-link
      :href="link"
      as="v-list-item" link
      @click="manageDrawer"

  >
    <v-list-item-icon>
      <v-icon>{{ icon }}</v-icon>
    </v-list-item-icon>

    <v-list-item-content>
      <v-list-item-title>{{ title }}</v-list-item-title>
    </v-list-item-content>
  </inertia-link>
</template>

<script>
export default {
  name: "sidebarLink",
  props: {
    title: String,
    link: String,
    icon: String,

    manageDrawer: {
      type: Function,
      required: true
    }
  }
}
</script>

<style scoped>

</style>