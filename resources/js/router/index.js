import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
//component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
const routes = [
  {
      path : '/acceuil',
      component: () => import(/* webpackChunkName: "main" */ '../pages/boardPage.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
