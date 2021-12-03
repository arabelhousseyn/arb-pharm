import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
//component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
const routes = [
  {
      path : '/acceuil',
      component: () => import(/* webpackChunkName: "main" */ '../pages/boardPage.vue')
  },
    {
        path : '/admin',
        component: () => import(/* webpackChunkName: "main" */ '../pages/adminPage.vue')
    },
    {
        path : '/admin/update/:id',
        component: () => import(/* webpackChunkName: "main" */ '../pages/adminProfilePage.vue')
    },
    {
        path : '/users',
        component: () => import(/* webpackChunkName: "main" */ '../pages/userPage.vue')
    },
    {
        path : '/users/update/:id',
        component: () => import(/* webpackChunkName: "main" */ '../pages/userInfoPage.vue')
    },
    {
        path : '/users/profile/:id',
        component: () => import(/* webpackChunkName: "main" */ '../pages/userProfilePage.vue')
    },
    {
        path : '/products',
        component: () => import(/* webpackChunkName: "main" */ '../pages/productPage.vue')
    },
    {
        path : '/requests',
        component: () => import(/* webpackChunkName: "main" */ '../pages/RequestPage.vue')
    },
    {
        path : '/profile',
        component: () => import(/* webpackChunkName: "main" */ '../pages/profileAdmin.vue')
    },
    {
        path : '*',
        component: () => import(/* webpackChunkName: "main" */ '../views/notfound.vue')
    },

]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
