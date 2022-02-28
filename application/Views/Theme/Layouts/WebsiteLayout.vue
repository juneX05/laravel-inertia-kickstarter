<template>
  <v-app>
    <v-navigation-drawer app v-model="drawer" class="brown lighten-2" dark disable-resize-watcher>
      <v-list>
        <template v-for="(item, index) in items">
          <v-list-item :key="index">
            <v-list-item-content>
              {{ item.title }}
            </v-list-item-content>
          </v-list-item>
          <v-divider :key="`divider-${index}`"></v-divider>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar app color="brown darken-4" dark>
      <v-app-bar-nav-icon class="hidden-md-and-up" @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-spacer class="hidden-md-and-up"></v-spacer>
      <v-toolbar-title>{{ $page.props.APP_NAME }}</v-toolbar-title>
      <v-spacer class="hidden-sm-and-down"></v-spacer>
      <v-btn text class="hidden-sm-and-down">SIGN IN</v-btn>
      <v-btn color="brown lighten-3" class="hidden-sm-and-down">JOIN</v-btn>
    </v-app-bar>

    <v-main app class="mb-5">
      <main>
        <slot></slot>
      </main>
    </v-main>
    <v-footer :app="false" class="brown darken-4 mt-5"  dark>
      <v-col cols="12" class="text-center">
        Copyright &copy; 2021  {{ $page.props.APP_NAME }}
      </v-col>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      drawer: false,
      items: [
        {title: 'Menu'},
        {title: 'Sign In'},
        {title: 'Join'}
      ]
    }
  }
};
</script>

<style>
html { overflow-y: auto }
</style>

