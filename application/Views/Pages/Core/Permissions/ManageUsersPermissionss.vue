<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permissions
            </h2>
        </template>

      <div class="row">
        <div class="col-md-6">

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">
                Manage Permissions for a User
              </h3>
              <div class="card-tools">

              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Select User</label>
                <select class="form-control select2"
                        @change="getUserPermissions"
                        style="width: 100%;" v-model="form.user_id">
                  <option value="" selected="selected">
                    -- Select User --
                  </option>
                  <option
                      :value="item.id"
                      v-for="(item, index) in users"
                      :key="index">
                    {{ item.name }}
                  </option>
                </select>
              </div>
            </div>

            <div class="card-footer">
              <button class="btn btn-primary" @click="submit">
                Save User
              </button>
            </div>

          </div>

        </div>

        <div class="col-md-6">

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">
                Assign Permissions for Selected User
              </h3>
              <div class="card-tools">

              </div>
            </div>
            <div class="card-body">
              <div v-if="form.user_id">
                <div class="overlay" v-if="permissions_loading">
                  <i class="fa fa-circle-notch fa-3x" ></i>
                </div>
                <div class="row">
                  <div class="col-md-12" v-for="(permission, index) in permissions" :key="permission.name">
                    <input type="checkbox" @click="console.log(permission_names)" :name="permission.name + 'checkbox'"
                           :data-index="index"
                           class="bootstrap-switch" :value="permission.name" data-state="true" data-size="mini"> {{ permission.name }}
                  </div>
                </div>
<!--                  <v-row v-else class="pt-3 pb-3 pl-2">-->
<!--                      <v-col cols="12" sm="12" md="6" class="pa-0 mb-1" v-for="permission in permissions" :key="permission.name">-->
<!--                          <v-checkbox  :label="permission.title" class="mt-0 " hide-details-->
<!--                                      :value="permission.name" v-model="permission_names" >-->
<!--                          </v-checkbox>-->
<!--                      </v-col>-->
<!--                  </v-row>-->

              </div>
            </div>

            <div class="card-footer">
              <button class="btn btn-primary" :disabled="loading" @click="submit">
                <i class="fa fa-circle-notch" v-if="loading"></i>
                Save User
              </button>
            </div>

          </div>

        </div>

      </div>

<!--        <v-row align="center" justify="center" align-content="center">-->
<!--            <v-col sm="12" md="8" lg="6">-->
<!--                <v-card class="mt-2">-->
<!--                    <v-card-title>-->
<!--                        Manage Permissions for a User-->
<!--                    </v-card-title>-->
<!--                    <v-card-text class="pb-0">-->
<!--                        <v-select-->
<!--                            v-model="form.user_id"-->
<!--                            hint="Select User to Manage Permissions"-->
<!--                            no-data-text="Select User to manage"-->
<!--                            :items="users"-->
<!--                            item-text="name"-->
<!--                            item-value="id"-->
<!--                            label="Select User"-->
<!--                            persistent-hint-->
<!--                            single-line-->
<!--                            clearable-->
<!--                            @change="getUserPermissions"-->
<!--                            :error="checkErrors('user_id')"-->
<!--                            :error-messages="errors.user_id"-->
<!--                        ></v-select>-->

<!--                        <div v-if="form.user_id" style="max-height: 35vh; overflow-x: hidden">-->
<!--                            <v-progress-circular v-if="permissions_loading"-->
<!--                                                 indeterminate-->
<!--                                                 color="primary"-->
<!--                            ></v-progress-circular>-->
<!--                            <v-row v-else class="pt-3 pb-3 pl-2">-->
<!--                                <v-col cols="12" sm="12" md="6" class="pa-0 mb-1" v-for="permission in permissions" :key="permission.name">-->
<!--                                    <v-checkbox  :label="permission.title" class="mt-0 " hide-details-->
<!--                                                :value="permission.name" v-model="permission_names" >-->
<!--                                    </v-checkbox>-->
<!--                                </v-col>-->
<!--                            </v-row>-->

<!--                        </div>-->
<!--                    </v-card-text>-->
<!--                    <v-card-actions class="pt-0 mt-2">-->
<!--                        <v-btn dark @click="submit" :loading="loading">Assign Permissions</v-btn>-->
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
    props: ['users','permissions','errors'],
    mounted() {
      this.initializeSelect2();
    },
    data() {
        return {
            drawer: null,
            form: this.$inertia.form({
                user_id: '',
            }),
            loading:false,
            permission_names : [],
            permissions_loading:false
        }
    },

    methods: {
      initializeSelect2() {
        $('.select2').select2();

        $('.select2').on("select2:select", (e) => {
          this.form.user_id = $(e.currentTarget).val();
          this.getUserPermissions();
        });
      },
      initializeBootstrapSwitch() {
        $(".bootstrap-switch").bootstrapSwitch({
          onSwitchChange: (e, state) => {
            let val = $(e.currentTarget).val();
            let index = $(e.currentTarget);
            console.log(index)
            if (state) {
              const index = this.permission_names.indexOf(val);
              if (index > -1) {
                this.permission_names.splice(index, 1); // 2nd parameter means remove one item only
              }
            }

          }
        });
      },
        submit() {
            this.loading = true;
            this.form
                .transform(data => ({
                    ... data,
                    permission_names: this.permission_names
                }))
                .post(this.route('saveUsersPermissions'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewPermissions'))
                    },
                    onError: () => {
                        console.log(this.errors)
                    },
                    onFinish: () => {
                        this.loading = false;
                    },
                })
        },
        getUserPermissions() {
            this.permissions_loading = true;
            axios.post(this.route('getUserPermissions'),{
                user_id: this.form.user_id
            })
            .then( response => {
                this.permission_names = response.data.user_permissions
                this.permissions_loading = false;

                //activate bootstrap switch.
              // this.initializeBootstrapSwitch();

              let _vm = this;
              $(".bootstrap-switch").each(function(){
                let val = $(this).val();
                $(this).bootstrapSwitch('state', _vm.permission_names.includes(val));
              })
            });
        },
        checkErrors(key) {
            return this.errors[key] !== undefined;
        }
    }
}
</script>
