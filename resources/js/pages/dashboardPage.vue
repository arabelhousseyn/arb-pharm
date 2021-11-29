<template>
    <div class="dashboard">
        <v-app>
           <sidebar-component />
            <router-view/>
            <footer-component />
        </v-app>
    </div>
</template>

<script>
import sidebarComponent from "../components/sidebarComponent"
import footerComponent from "../components/footerComponent"
export default {
    props : ['user'],
  data : () => {
    return{

    }
  },
  components : {
      sidebarComponent,
      footerComponent
  },
  created()
  {
      this.$store.commit('setUser',this.user)
  }
}
</script>
