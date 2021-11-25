<template>
    <div class="appbar">
        <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="primary lighten-1" dark>
            <v-app-bar-nav-icon @click.stop="toggle"></v-app-bar-nav-icon>
            <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span class="hidden-sm-and-down">
            <v-btn large to="/accueil" text>
                <v-img src="../assets/pharm.png" width="60"></v-img>
            </v-btn>
        </span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-badge color="error" :content="$store.state.count" class="mr-2" overlap
                     :value="$store.state.count!==0">
                <v-btn to="/" icon >
                    <v-icon>mdi-bell</v-icon>
                </v-btn>
            </v-badge>
            <v-btn icon dark class="mr-2">
                <v-icon>mdi-logout</v-icon>
            </v-btn>
            <v-btn large to="/my-account" text>
                <v-avatar size="38px" item class="mr-2">
                    <v-img src="../assets/profile.png"></v-img>
                </v-avatar>
                {{$store.state.fullName}}
            </v-btn>
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
    methods : {
      toggle()
      {
          this.$emit('toggle')
      }
    },
  components : {
    profileComponent
  }
}
</script>
