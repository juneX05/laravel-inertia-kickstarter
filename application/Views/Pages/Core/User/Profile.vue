<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Profile
            </h2>
        </template>

      <div class="row">
        <div class="col-md-3">

          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     :src="user.profile_photo_url"
                     alt="User profile picture">
              </div>
              <h3 class="profile-username text-center">
                {{ user.name }}
              </h3>
              <p class="text-muted text-center">
                <span class="badge badge-danger" v-if="user.status_id === '2'">In Active</span>
                <span class="badge badge-success" v-if="user.status_id === '1'">Active</span>
              </p>
            </div>
          </div>

        </div>

        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="#user_info" data-toggle="tab">User Info</a></li>
                <li class="nav-item"><a class="nav-link" href="#permissions" data-toggle="tab">Permissions</a></li>
                <li class="nav-item"><a class="nav-link" href="#passwords" data-toggle="tab">Change Password</a></li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">

                <div class="tab-pane" id="user_info">

                  <edit-user
                    :data="user"
                  ></edit-user>

                </div>

                <div class="tab-pane" id="permissions">
                  <user-permissions
                    :data="user"
                    :permissions="permissions"
                    :user_permissions="user_permissions"
                  ></user-permissions>

                </div>

                <div class="tab-pane" id="passwords">

                  <change-password></change-password>

                </div>

              </div>

            </div>
          </div>

        </div>

      </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Theme/Layouts/AppLayout";
import EditUser from "../Users/Edit";
import ManageUserPermissions from "../Users/ManageUserPermissions";
import ChangePassword from "./ChangePassword";
import UserPermissions from "./UserPermissions";
export default {
    name: "Profile",
  props: {
    user: Object,
    user_permissions: Array,
    permissions: Array,
  },
    components: {UserPermissions, ChangePassword, ManageUserPermissions, EditUser, AppLayout},
  methods:{

  }
}
</script>

<style scoped>

</style>
