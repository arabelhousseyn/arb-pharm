<template>
 <div>
     <v-container style="text-align: center;" fluid>
         <v-avatar
             color="white"
             size="200"
         >
             <v-img src="https://arb.arbpharm.com/assets/profile.png" lazy-src="https://arb.arbpharm.com/assets/profile.png"></v-img>
         </v-avatar>
     </v-container>
     <v-container style="text-align: center;" fluid>
         <h3>{{ name }}</h3>
     </v-container>
 </div>
</template>

<script>
export default {
    props : ['name']
}
</script>
