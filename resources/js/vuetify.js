
import Vue from 'vue'
import Vuetify from "vuetify"
import 'vuetify/dist/vuetify.min.css'
// import '@fortawesome/fontawesome-free/css/all.css'

Vue.use(Vuetify)

export default new Vuetify({
    // lang: {
    //     locales: { ptBr },
    //     current: 'ptBr',
    // },
    // icons: {
    //     iconfont: 'mdi'
    // },
    // theme: {
    //     themes: {
    //         light: {
    //             primary: '#00551E',
    //             secondary: '#3C8750',
    //             tertiary: '#EEEEEE',
    //             accent: '#69FFF1',
    //             info: '#63D471',
    //             success: '#4CAF50',
    //             warning: '#FFC107',
    //             error: '#FF5252',
    //             danger: '#FF5252',
    //         },
    //         dark: {
    //             primary: '#321321'
    //         }
    //     }
    // },
    theme: {light: true}
})
