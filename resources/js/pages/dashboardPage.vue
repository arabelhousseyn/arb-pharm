<template>
    <div class="dashboard">
        <v-app>
          <appbar-component />
    <v-main style="margin-top:75px;" class="main">
      <main-page />
    </v-main>
        </v-app>
    </div>
</template>

<script>
import appbarComponent from '../components/appbarComponent.vue'
import mainPage from './/mainPage.vue'
export default {
  data : () => {
    return{

    }
  },
  components : {
    appbarComponent,
    mainPage
  },
  created()
  {
    const name = document.head.querySelector('meta[name="fullName"]').content
    this.$store.commit('setName',name)
  }
}
</script>