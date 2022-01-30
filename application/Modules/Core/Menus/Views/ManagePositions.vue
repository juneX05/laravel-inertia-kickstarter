<template>
    <app-layout>
      <template #bread-crumbs>
        <inertia-link :href="route('home')" style="text-decoration: none">
          <v-icon size="16" style="margin-top: -2px">home</v-icon>
        </inertia-link>
        /
        <inertia-link :href="route('viewMenus')" style="text-decoration: none">
          Menus List
        </inertia-link>
        <span class="text-md">
                / Manage Menu Positions
            </span>

        <br/>
        <inertia-link :href="route('viewMenus')" as="v-btn" class="mt-2" small style="text-decoration: none">
          <v-icon>arrow_back</v-icon>
          Back
        </inertia-link>
      </template>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Menu Positions
        </h2>
      </template>

        <v-row align="center" align-content="center" justify="center">
            <v-col cols="8">
                <v-card class="mt-2">
                    <v-card-title>
                        MANAGE Menu Positions
                    </v-card-title>
                    <v-card-text class="pb-0">

                      <v-list dense height="50px" v-for="(key, index) in keys" :key="index">
                        <v-list-item>
                          <v-list-item-icon v-if="sidebar_links[key].icon">
                            <v-icon>{{  sidebar_links[key].icon }}</v-icon>
                          </v-list-item-icon>
                          <v-list-item-title>
                            {{ sidebar_links[key].title }}
                          </v-list-item-title>

                          <v-list-item-subtitle>
                            {{ sidebar_links[key].menu_type ? sidebar_links[key].menu_type : 'link' }}
                          </v-list-item-subtitle>

                          <v-list-item-action >
                            <v-btn icon :disabled="index == 0" @click="changeIndex(index, index-1)">
                              <v-icon>mdi-arrow-up</v-icon>
                            </v-btn>
                          </v-list-item-action>
                          <v-list-item-action>
                            <v-btn icon :disabled="index == menu_keys.length - 1"  @click="changeIndex(index, index+1)">
                              <v-icon>mdi-arrow-down</v-icon>
                            </v-btn>
                          </v-list-item-action>
                        </v-list-item>
                      </v-list>

                    </v-card-text>
                    <v-card-actions class="pt-5">
                        <v-btn :loading="loading" dark @click="submit">Update Menu Positions</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

        </v-row>

    </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
export default {
    components: {
        AppLayout,
    },
    props: ['errors','menu_keys', 'sidebar_links'],
    mounted() {
        console.log(this.menus)
    },
    data() {
        return {
            drawer: null,
            // form: this.permission,
          keys: this.menu_keys,
            form: this.$inertia.form({
                menus: {}
            }),
            loading:false
        }
    },

    methods: {
        changeIndex(from, to) {
          let new_keys = [];
          let count = this.keys.length;
          for (let i = 0; i < count; i++) {
            if (i == from) {
              new_keys.push(this.keys[to]);
            }
            else if (i == to) {
              new_keys.push(this.keys[from]);
            }
            else {
              new_keys.push(this.keys[i]);
            }
          }
            this.keys = new_keys;
        },
        submit() {
          console.log(this.keys);

            this.form
                .transform(data => ({
                    ... data, menu_keys: this.keys
                }))
                .post(this.route('updatePositions'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewMenus'))
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
