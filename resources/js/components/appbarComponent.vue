<template>
    <div class="appbar">
            <v-app-bar
      absolute
      color="white"
      elevation="2"
    >
      <v-app-bar-nav-icon ></v-app-bar-nav-icon>

      <v-toolbar-title><v-img src="assets/pharm.png" alt="Eurl ARB PHARM" max-height="50" max-width="50"></v-img></v-toolbar-title>

      <v-spacer></v-spacer>

      <profile-component />
    </v-app-bar>
    </div>
</template>

<script>
import profileComponent from '../components/profileComponent.vue'
export default {
  data : () =>{
    return{
      
    }
  },
  components : {
    profileComponent
  }
}
</script>