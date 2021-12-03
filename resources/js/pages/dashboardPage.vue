<template>
    <div class="dashboard">
        <v-app>
           <sidebar-component />
            <v-main>
                <transition name="slide-fade">
                <router-view />
                </transition>
            </v-main>
            <footer-component />
        </v-app>
    </div>
</template>
<style>
.slide-fade-enter-active {
    transition: all .2s ease;
}
.slide-fade-leave-active {
    transition: all .2s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to{
    transform: translate(0px,20px);
    opacity: 0;
}
</style>


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
