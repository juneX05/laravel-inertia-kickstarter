require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';

import vuetify from './vuetify'
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
    vuetify,
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                // resolveComponent: (name) => require(`./Pages/${name}`).default,
                resolveComponent: (name) => require(`../../application/Modules/${name}`).default,
            },
        }),
}).$mount(app);
