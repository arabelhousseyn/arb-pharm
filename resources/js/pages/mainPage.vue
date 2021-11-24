<template>
<div>
    <v-row no-gutters>
      <v-col cols="4" sm="2">
          <sidebar-component />
      </v-col>
      <v-col
        cols="12" sm="6" md="8" >
      <router-view />
      </v-col>
    </v-row>
</div>
</template>

<script>
import sidebarComponent from '../components/sidebarComponent.vue'
export default {
    components : {
        sidebarComponent
    }
}
</script>