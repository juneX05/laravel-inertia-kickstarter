<template>
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!--        <li class="nav-item d-none d-sm-inline-block">-->
        <!--          <a href="index3.html" class="nav-link">Home</a>-->
        <!--        </li>-->
        <!--        <li class="nav-item d-none d-sm-inline-block">-->
        <!--          <a href="#" class="nav-link">Contact</a>-->
        <!--        </li>-->
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <!--            <i class="far fa-bell"></i>-->
            <!--            <span class="badge badge-warning navbar-badge">15</span>-->
            {{ this.$page.props.user.name }} <i class="right fas fa-angle-down"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">
              {{ this.$page.props.user.name }}
            </span>
            <div class="dropdown-divider"></div>

            <inertia-link class="dropdown-item" :href="route('viewUserProfile')">
              <i class="fas fa-user mr-2"></i> Profile
            </inertia-link>

            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> Change Password
              <!--              <span class="float-right text-muted text-sm">12 hours</span>-->
            </a>
            <!--            <div class="dropdown-divider"></div>-->
            <!--            <a href="#" class="dropdown-item">-->
            <!--              <i class="fas fa-file mr-2"></i> 3 new reports-->
            <!--              <span class="float-right text-muted text-sm">2 days</span>-->
            <!--            </a>-->
            <!--            <div class="dropdown-divider"></div>-->
            <!--            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>-->
          </div>
        </li>
        <!--        <li class="nav-item">-->
        <!--          <a class="nav-link" data-widget="fullscreen" href="#" role="button">-->
        <!--            <i class="fas fa-expand-arrows-alt"></i>-->
        <!--          </a>-->
        <!--        </li>-->
        <!--        <li class="nav-item">-->
        <!--          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">-->
        <!--            <i class="fas fa-power-off"></i>-->
        <!--          </a>-->
        <!--        </li>-->
        <li class="nav-item">
          <a class="nav-link text-red" href="#" role="button" @click="logout">
            <i class="fas fa-power-off"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <img src="/img/avatar.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">
            {{ this.$page.props.APP_NAME }}
          </span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="/img/avatar.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <!--        <div class="form-inline">-->
        <!--          <div class="input-group" data-widget="sidebar-search">-->
        <!--            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">-->
        <!--            <div class="input-group-append">-->
        <!--              <button class="btn btn-sidebar">-->
        <!--                <i class="fas fa-search fa-fw"></i>-->
        <!--              </button>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <sidebar></sidebar>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                <slot name="header"></slot>
              </h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <slot></slot>
      </div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <!--      <aside class="control-sidebar control-sidebar-dark">-->
    <!--        &lt;!&ndash; Control sidebar content goes here &ndash;&gt;-->
    <!--        <div class="p-3">-->
    <!--          <h5>Title</h5>-->
    <!--          <p>Sidebar content</p>-->
    <!--        </div>-->
    <!--      </aside>-->
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
  </div>
</template>

<script>
import Sidebar from "@/Theme/Components/sidebar";
export default {
  components: {Sidebar},
  data() {
    return {
      drawer: false,
      items: [
        {title: 'Dashboard', icon: 'mdi-view-dashboard', link: '/dashboard', permission: "dashboard.view"},
        {title: 'Permissions', icon: 'mdi-forum', link: '/permissions', permission: "permissions.view"},
        {title: 'Users', icon: 'mdi-account', link: '/users', permission: "users.view"},
      ],
      user_items: [
        {title: 'Profile', icon: 'mdi-view-dashboard'},
        {title: 'Logout', icon: 'mdi-forum',},
      ],
    }
  },
  mounted() {
    if($('body').hasClass('sidebar-open')) {
      $('body')
          .removeClass('sidebar-open')
          .addClass('sidebar-closed sidebar-collapsed sidebar-collapse')
    }

    $('body')
        .addClass('sidebar-mini layout-fixed')
        .removeClass('layout-top-nav')
        .Layout('fixLayoutHeight')
  },
  methods: {
    switchToTeam(team) {
      this.$inertia.put(route('current-team.update'), {
        'team_id': team.id
      }, {
        preserveState: false
      })
    },

    logout() {
      this.$inertia.post(route('logout'));
    },

    profile() {
      this.$inertia.post(route('userProfile'));
    },

    manageDrawer() {
      if (this.drawer) {
        this.drawer = false;
      }
    }
  }
}
</script>

<style>
html {
  overflow-y: auto
}
.v-application--is-ltr .v-list-item__action:first-child, .v-application--is-ltr .v-list-item__icon:first-child {
  margin-right: 16px;
}
.v-select.v-input--dense .v-chip {
  margin: 4px 4px;
}

.up_icon > span {
  display: flex;
  flex-direction: column;
}
</style>
