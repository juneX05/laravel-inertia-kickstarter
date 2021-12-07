<template>
  <v-container>
    <v-row>
      <v-col cols="12"  class="display-2 text-center my-5" id="categories">Categories</v-col>
      <v-col cols="6" >
        <v-list-item @click="goToPage('category.one')">
          <v-list-item-icon>
            <v-icon> mdi-account </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>
              Category One
            </v-list-item-title>
            <v-list-item-subtitle>
              The long description for category one with wonderful information
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-col>
      <v-col cols="6" >
        <v-list-item @click="goToPage('category.one')">
          <v-list-item-icon>
            <v-icon> mdi-account </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>
              Category One
            </v-list-item-title>
            <v-list-item-subtitle>
              The long description for category one with wonderful information
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-col>
      <v-col cols="6" >
        <v-list-item @click="goToPage('category.one')">
          <v-list-item-icon>
            <v-icon> mdi-account </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>
              Category One
            </v-list-item-title>
            <v-list-item-subtitle>
              The long description for category one with wonderful information
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-col>
      <v-col cols="6" >
        <v-list-item @click="goToPage('category.one')">
          <v-list-item-icon>
            <v-icon> mdi-account </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>
              Category One
            </v-list-item-title>
            <v-list-item-subtitle>
              The long description for category one with wonderful information
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-col>



    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'HomeDetails',
  methods : {
    goToPage(link, params = []) {
      this.$inertia.visit(route(link), params)
    }
  }
};
</script>

<style scoped>
</style>