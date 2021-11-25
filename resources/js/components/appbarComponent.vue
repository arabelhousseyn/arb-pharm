<template>
    <div class="appbar">
        <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app>
            <v-app-bar-nav-icon @click.stop="toggle"></v-app-bar-nav-icon>
            <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span class="hidden-sm-and-down">
            <v-btn large to="/accueil" text>
                <v-img src="../assets/pharm.png" width="60"></v-img>
            </v-btn>
        </span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <badge-component />
            <menu-component />
        </v-app-bar>
    </div>
</template>

<script>
import menuComponent from "./menuComponent"
import badgeComponent from './badgeComponent'
export default {
  data : () =>{
    return{
        fav: true,
        menu: false,
        message: false,
        hints: true,
    }
  },
    methods : {
      toggle()
      {
          this.$emit('toggle')
      }
    },
  components : {
      menuComponent,
      badgeComponent
  }
}
</script>
