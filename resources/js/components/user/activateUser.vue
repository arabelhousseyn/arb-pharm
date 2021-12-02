<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="900px"
    >
        <v-card>
            <v-card-title>
                Activation
            </v-card-title>
            <v-card-text>
                <v-select
                    @change="check"
                    v-model="selection"
                    :items="select"
                    label="Sélectionné le nombre de jours"
                    item-value="text"
                ></v-select>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    color="primary"
                    text
                    @click="close"
                >
                    Fermer
                </v-btn>

                <v-btn
                    color="success"
                    text
                    :disabled="disable"
                    @click="activate"
                >
                    Activé <v-icon>mdi-power</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props : ['dialog','selected'],
    data () {
        return {
            disable : true,
            selection : null,
            select: [
                { text: 30 }
            ],
        }
    },
    methods : {
        close()
        {
            this.$emit('close',true)
        },
        check()
        {
          this.disable = false
        },
        activate()
        {
            let data = {
                days : this.selection
            }
            let req  = axios.put(`/api/dashboard/activateUser/${this.selected[0].id}`,data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                this.$emit('active',true)
                this.disable = true
            })
            req.catch(err => {
                console.log(err)
            })
        }
    }
}
</script>
