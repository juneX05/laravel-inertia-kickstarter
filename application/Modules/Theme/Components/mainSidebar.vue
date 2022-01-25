<template>
  <v-list dense>
    <template v-for="(item, index) in sidebar_items">
      <v-list-item v-if="authRoute(item) && !item.children" :key="index" :exact="item.meta.exact"
                   :to="{name:item.name}">
        <v-list-item-action>
          <v-icon>{{ item.meta.icon }}</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ item.meta.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-group v-if="authRoute(item) && item.children" :key="index" :value="$route.name === item.name" no-action>
        <template v-slot:activator>
          <v-list-item-action>
            <v-icon>{{ item.meta.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ item.meta.title }}</v-list-item-title>
          </v-list-item-content>
        </template>

        <template v-for="(child,child_index) in item.children">
          <v-list-item v-if="!child.children" :key="child_index" :exact="child.meta.exact" :to="{name:child.name}">
            <v-list-item-action>
              <v-icon>{{ child.meta.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ child.meta.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list-group>
    </template>
  </v-list>
</template>


<script>
export default {
  data: () => ({
    sidebar_items: this.$page.props.menus
  }),
  methods: {}
}

</script>

