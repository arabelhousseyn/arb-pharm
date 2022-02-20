<template>
    <div>
        <v-btn icon>
            <v-icon>mdi-bell</v-icon>
            <v-badge color="red" :content="count_notification"></v-badge>
        </v-btn>
    </div>
</template>
<script>
import io from 'socket.io-client'
 export default {
    data : ()=>{
        return{
            socket : null,
            notifications : null,
            count_notification : null,
            fav: true,
            menu: false,
            message: false,
            hints: false,
        }
    },
     created() {
        this.socket = io('https://frozen-coast-82543.herokuapp.com/')
         let req  = axios.get('/api/dashboard/admin/notification',{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
         req.then(e=>{
             this.notifications = e.data.notifications
             this.count_notification = e.data.count
         })
         req.catch(err => {
             console.log(err)
         })
         this.socket.on('check_registration',(data)=>{
             let req1 = axios.get('/api/dashboard/admin/notification',{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
             req1.then(e=>{
                 this.notifications = e.data.notifications
                 this.count_notification = e.data.count
                 var notification = new Notification('Notification', { body: 'Nouveaux utilisateur'});
             })
             req1.catch(err => {
                 console.log(err)
             })
         })
     }
 }
</script>
