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
    const name = document.head.querySelector('meta[name="fullName"]').content
    this.$store.commit('setName',name)
  }
}
</script>
