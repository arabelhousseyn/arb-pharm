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
                <v-btn :disabled="disabled" @click="update" color="green"><span style="color: white;">Modifier </span> <v-icon color="white" >mdi-wrench</v-icon> </v-btn>
                <v-btn :disabled="disabled" @click="remove"  color="red"><span style="color: white;">Supprimer </span> <v-icon color="white" >mdi-delete</v-icon> </v-btn>
            </v-card-subtitle>
            <v-data-table
                v-model="selected"
                :headers="headers"
                :items="desserts"
                class="elevation-1"
                :loading="loading"
                :search="search"
                :single-select="singleSelect"
                show-select
                @item-selected="watch"
            ></v-data-table>
            <dialog-comp :dialog="open" :selected="selected" v-on:close="close" />
        </v-card>
    </div>
</template>

<script>
import dialogComp from "./dialog";
export default {
    data () {
        return {
            search: '',
            open : false,
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
                { text: 'E-mail', value: 'email' },
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

        },
        update()
        {
          this.$router.push(`/admin/update/${this.selected[0].id}`)
        },
        remove()
        {
            this.open = true
        },
        close(val)
        {
            if(val)
            {
                for (const sel of this.selected) {
                 this.desserts = this.desserts.filter(e=> e.id !== sel.id)
                }
                this.selected = []
                this.open = false
                this.disabled = true
            }
        }
    },
    components : {
        dialogComp
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
