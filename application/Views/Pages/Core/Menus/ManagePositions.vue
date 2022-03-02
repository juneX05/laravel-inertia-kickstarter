<template>
    <app-layout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Menu Positions
        </h2>
      </template>

      <div class="row">
        <div class="col-sm-8 m-auto">
          <div class="card">
            <div class="card-header">
              MANAGE MENU POSITIONS
            </div>
            <div class="card-body">
              <ul>
                <template v-for="(menu, index) in getMenuPositions">
{{index}}
                  <div class="card">
                    <div class="card-header">
                      <h2 class ="card-title">
                        <i :class="'fa '+menu.icon"></i>
                        {{ menu.title }}
                      </h2>
                      <br/>
                      <small>
                        {{ menu.menu_type ? menu.menu_type : 'link' }}
                      </small>
                      <div class="card-tools">
                        <button class="btn btn-primary" v-if="index !== 0" @click="changeIndex(index, index-1)">
                          <i class="fa fa-arrow-up"></i>
                        </button>
                        <button class="btn btn-primary" v-if="keys.length - 1 > index" @click="changeIndex(index, index+1)">
                          <i class="fa fa-arrow-down"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </template>
              </ul>
            </div>
            <div class="card-footer">
              <button class="btn btn-primary" @click="submit">
                Update Menu Positions
              </button>
            </div>
          </div>
        </div>
      </div>

<!--        <v-row align="center" align-content="center" justify="center">-->
<!--            <v-col cols="8">-->
<!--                <v-card class="mt-2">-->
<!--                    <v-card-title>-->
<!--                        MANAGE Menu Positions-->
<!--                    </v-card-title>-->
<!--                    <v-card-text class="pb-0">-->

<!--                      <v-list dense height="50px" v-for="(key, index) in keys" :key="index">-->
<!--                        <v-list-item>-->
<!--                          <v-list-item-icon v-if="sidebar_links[key].icon">-->
<!--                            <v-icon>{{  sidebar_links[key].icon }}</v-icon>-->
<!--                          </v-list-item-icon>-->
<!--                          <v-list-item-title>-->
<!--                            {{ sidebar_links[key].title }}-->
<!--                          </v-list-item-title>-->

<!--                          <v-list-item-subtitle>-->
<!--                            {{ sidebar_links[key].menu_type ? sidebar_links[key].menu_type : 'link' }}-->
<!--                          </v-list-item-subtitle>-->

<!--                          <v-list-item-action >-->
<!--                            <v-btn icon :disabled="index == 0" @click="changeIndex(index, index-1)">-->
<!--                              <v-icon>mdi-arrow-up</v-icon>-->
<!--                            </v-btn>-->
<!--                          </v-list-item-action>-->
<!--                          <v-list-item-action>-->
<!--                            <v-btn icon :disabled="index == menu_keys.length - 1"  @click="changeIndex(index, index+1)">-->
<!--                              <v-icon>mdi-arrow-down</v-icon>-->
<!--                            </v-btn>-->
<!--                          </v-list-item-action>-->
<!--                        </v-list-item>-->
<!--                      </v-list>-->

<!--                    </v-card-text>-->
<!--                    <v-card-actions class="pt-5">-->
<!--                        <v-btn :loading="loading" dark @click="submit">Update Menu Positions</v-btn>-->
<!--                    </v-card-actions>-->
<!--                </v-card>-->
<!--            </v-col>-->

<!--        </v-row>-->

    </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
export default {
    components: {
        AppLayout,
    },
    props: ['errors','menu_keys', 'menus'],
    mounted() {

    },
    data() {
        return {
            drawer: null,
          keys: this.menu_keys,
            form: this.$inertia.form({
                menus: {}
            }),
            loading:false
        }
    },
    computed : {
      getMenuPositions() {
        let menus = [];
        this.keys.forEach( (key) => {
          let key_split = key.split('.');

          let menu_index = this.menus.findIndex( (item) => {
            if (key_split.length === 1) {
              return (item.id === key)
            } else {
              return (item.id === key_split[1])
            }
          });
          if (menu_index !== -1) {
            // if (key_split.length === 1) {
            //   menus[key] = (this.menus[menu_index])
            // } else {
            //   menus[key_split[1]] = (this.menus[menu_index])
            // }
            menus.push(this.menus[menu_index])
          }
        })

        return menus;
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
                    ... data, menu_keys: this.getMenuPositions.map( (menu) => {
                      return menu.id
                  })
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
