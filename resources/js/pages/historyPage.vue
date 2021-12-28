<template>
    <div>
        <v-container fluid>
            <v-btn @click="back" fab color="primary"> <v-icon color="white">mdi-arrow-left</v-icon> </v-btn>
            <div style="margin-top: 25px;">
                <breadcrumbs />
            </div>
        </v-container>
        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Rechercher"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="desserts"
                class="elevation-1"
                :loading="loading"
                :search="search"
            >
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
import Breadcrumbs from "../components/breadcrumbs/breadcrumbs"
export default {
    components: {Breadcrumbs},
    data () {
        return {
            search: '',
            desserts: [],
            loading: true,
            headers: [
                { text: 'Statu', value: 'status',align: 'start', sortable: true,},
                { text: 'Date d\'activation', value: 'activated_at'},
                { text: 'Date d\'expiration', value: 'expired_at' }
            ],
        }
    },
    methods : {
        back()
        {
            this.$router.push('/users')
        }
    },
    async created() {
        let req  = axios.get(`/api/dashboard/user/subscribe-history/${this.$route.params.id}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
        await req.then(e=>{
            this.desserts = e.data
            this.desserts = this.desserts.reverse()
            let inc = 0
            for (let fruit of this.desserts) {
                if(inc == 0)
                {
                    this.desserts[inc].status = 'Actuel'
                }else{
                    this.desserts[inc].status = 'Ancien'
                }
                this.desserts[inc].activated_at = fruit.activated_at.toString().slice(0,10)
                inc++
            }
            console.log(this.desserts)
            this.loading = false
        })
        req.catch(err => {
            console.log(err)
        })
    }
}
</script>
