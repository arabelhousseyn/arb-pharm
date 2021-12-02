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
                <v-btn :disabled="switch1" @click="openDiag" color="green"><span style="color: white;">Activé</span> <v-icon color="white" >mdi-power</v-icon> </v-btn>
                <v-btn :disabled="switch2" @click="opendag" color="red"><span style="color: white;">désactivé</span> <v-icon color="white" >mdi-minus</v-icon> </v-btn>
                <v-btn :disabled="disabled" @click="redirect"  color="primary"><span style="color: white;">Profile</span> <v-icon color="white" >mdi-account</v-icon> </v-btn>
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
            >
            </v-data-table>
            <dialog-comp :dialog="open" :selected="selected" v-on:close="close" v-on:close2="close2" />
            <activate-user :dialog="diag" :selected="selected" v-on:close="close3" v-on:active="active" />
            <deactive-user :dialog="dag" :selected="selected" v-on:close="close4" v-on:deactive="deactive" />
            <snackbar-comp :snackbar="snack" />
        </v-card>
    </div>
</template>

<script>
import dialogComp from "./dialog"
import activateUser from "./activateUser"
import deactiveUser from "./deactiveUser"
import snackbarComp from "../snackbar/snackbar"
export default {
    data () {
        return {
            search: '',
            open : false,
            singleSelect: true,
            disabled : true,
            snack : false,
            selected: [],
            desserts: [],
            loading: true,
            switch1 : true,
            switch2 : true,
            diag : false,
            dag : false,
            headers: [
                {
                    align: 'start',
                    sortable: true,
                    text: 'E-mail',
                    value: 'email'
                },
                { text: 'Téléphone', value: 'phone' },
                { text: 'Activation', value: 'activation' },
                { text: 'Date d\'activation', value: 'activation_date' },
                { text: 'Type', value: 'type' },
                { text: 'Crée', value: 'date_creation' },
            ],
        }
    },
    methods: {
        watch(item)
        {
            this.disabled = (item.value) ? false : true
            this.switch1 = (item.value) ? false : true
            this.switch2 = (item.value) ? false : true

                if(item.item.is_active)
                {
                    this.switch1 = true
                }else{
                    this.switch2 = true
                }

        },
        update()
        {
            this.$router.push(`/users/update/${this.selected[0].id}`)
        },
        remove()
        {
            this.open = true
        },
        openDiag()
        {
            this.diag = true
        },
        opendag()
        {
            this.dag = true
        },
        redirect()
        {
          this.$router.push(`/users/profile/${this.selected[0].id}`)
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
        },
        close2()
        {
                this.open = false
        },
        close3()
        {
            this.diag = false
        },
        close4()
        {
            this.dag = false
        },
        active()
        {
            this.snack = true
            this.diag = false
            this.switch1 = true
            for (const dessert of this.desserts) {
                if(dessert.id == this.selected[0].id)
                {
                    dessert.activation = 'Activé'
                    dessert.is_active = true
                    location.reload()
                }
            }
            this.selected = []
            setTimeout(()=>{
                this.snack = false
            },2000)
        },
        deactive()
        {
            this.snack = true
            this.switch2 = true
            this.dag = false
            for (const dessert of this.desserts) {
                if(dessert.id == this.selected[0].id)
                {
                    dessert.activation = 'Non activé'
                    dessert.activation_date = '/'
                    dessert.type = ''
                    dessert.is_active = false
                }
            }
            this.selected = []
            setTimeout(()=>{
                this.snack = false
            },2000)
        }
    },
    components : {
        dialogComp,
        activateUser,
        deactiveUser,
        snackbarComp
    },
    async created() {
        let req  = axios.get('/api/dashboard/user',{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
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
