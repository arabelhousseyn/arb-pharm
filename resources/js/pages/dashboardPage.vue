<template>
    <div class="dashboard">
        <v-app>
           <sidebar-component />
            <v-main>
                <router-view/>
            </v-main>
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
      let token = document.head.querySelector("meta[name='bhr']").content
      this.$store.commit('SET_TOKEN',token)
      this.$store.commit('SET_USER',this.user)

      let req  = axios.get('/api/dashboard/getInformations',{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
       req.then(e=>{
          this.$store.commit('SET_INFOS',e.data)
      })
      req.catch(err => {
          console.log(err)
      })
  }
}
</script>

<style>
 a{
     text-decoration: none !important;
 }
</style>
