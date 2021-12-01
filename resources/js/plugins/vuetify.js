import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'
Vue.use(Vuetify)

export default new Vuetify({
    theme: { dark: (window.localStorage.getItem('darkMode') == null) ? false : true },
    icons: {
        iconfont: 'mdi',
      },
})
