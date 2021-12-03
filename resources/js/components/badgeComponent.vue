<template>
    <div>
        <v-btn icon>
            <v-icon>mdi-bell</v-icon>
            <v-badge color="red"></v-badge>
        </v-btn>
    </div>
</template>
<script>
 export default {
     created() {
         Echo.channel('events')
             .listen('UserRegistration', (e) => console.log('UserRegistration: ' + e.message));
     }
 }
</script>
