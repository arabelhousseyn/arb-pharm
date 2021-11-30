import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
      user : {},
      token : null,
      cards : [
          {
              title : "Administrateurs",
              icon : "mdi-email",
              value : 2
          },
          {
              title : "Utilisateurs",
              icon : "mdi-email",
              value : 2
          },
          {
              title : "Produits",
              icon : "mdi-email",
              value : 2
          },
          {
              title : "Demandes de devis",
              icon : "mdi-email",
              value : 2
          }
      ]
  },
  mutations: {
      SET_USER(state,obj)
      {
          state.user = obj
      },
      SET_INFOS(state,info)
      {
         state.cards = info
      },
      SET_TOKEN(state,token)
      {
          state.token = token
      }
  },
  actions: {
  },
  modules: {
  }
})
