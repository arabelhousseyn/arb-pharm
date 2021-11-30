<template>
    <div>
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
            <v-spacer></v-spacer>
            <v-card-subtitle>
                <v-btn :disabled="disabled" color="green"><span style="color: white;">Modifier </span> <v-icon color="white" >mdi-wrench</v-icon> </v-btn>
                <v-btn :disabled="disabled"  color="red"><span style="color: white;">Supprimer </span> <v-icon color="white" >mdi-delete</v-icon> </v-btn>
                <v-btn :disabled="disabled"  color="warning"><span style="color: white;">Récupérer </span> <v-icon color="white" >mdi-recycle</v-icon></v-btn>
            </v-card-subtitle>
            <v-data-table
                v-model="selected"
                :headers="headers"
                :items="desserts"
                class="elevation-1"
                :loading="loading"
                :search="search"
                :single-select="singleSelect"
                item-key="name"
                show-select
                @item-selected="watch"
            ></v-data-table>
        </v-card>
    </div>
</template>

<script>
export default {
    data () {
        return {
            search: '',
            singleSelect: true,
            disabled : true,
            selected: [],
            desserts: [],
            loading: true,
            headers: [
                {
                    text: 'Nom',
                    align: 'start',
                    sortable: true,
                    value: 'lname',
                },
                { text: 'Prénom', value: 'fname' },
                { text: 'e-mail', value: 'email' },
                { text: 'Téléphone', value: 'phone' },
                { text: 'Nom d\'utilisateur', value: 'username' },
                { text: 'crée', value: 'date_creation' },
            ],
        }
    },
    methods: {
        watch()
        {
            this.disabled = (this.selected.length == 0) ? false : true
        }
    },
    async created() {
        let req  = axios.get('/api/dashboard/admin',{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
        await req.then(e=>{
            this.desserts = e.data
            this.loading = false
        })
        req.catch(err => {
            console.log(err)
        })
    }
}
</script>
