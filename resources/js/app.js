require('./bootstrap');

// Import modules...
import Vue from 'vue';
// import moment from 'moment';
// import Swal from 'sweetalert2';
//
// const Toast = Swal.mixin({
//     toast: true,
//     position: 'top-end',
//     showConfirmButton: false,
//     timer: 3000,
//     timerProgressBar: true,
//     onOpen: (toast) => {
//         toast.addEventListener('mouseenter', Swal.stopTimer)
//         toast.addEventListener('mouseleave', Swal.resumeTimer)
//     }
// })
// window.Swal = Swal;
// window.Toast = Toast;

import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';

// import vuetify from './vuetify'
// import 'vuetify/dist/vuetify.min.css'
// import '@mdi/font/css/materialdesignicons.css'
import VueApexCharts from 'vue-apexcharts'

Vue.mixin({methods: {route}});
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                // resolveComponent: (name) => require(`./Pages/${name}`).default,
                resolveComponent: (name) => require(`../../application/Modules/${name}`).default,
            },
        }),
}).$mount(app);
