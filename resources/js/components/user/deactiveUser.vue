<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="900px"
    >
        <v-card>
            <v-card-title>
                Désactivation
            </v-card-title>
            <v-card-text>
                si vous êtes sûr de désactivé appuyer sur <span style="font-weight: bold">désactivé</span> sinon <span style="font-weight: bold">Fermer</span>
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
                    color="red"
                    text
                    @click="deactivate"
                >
                    désactivé <v-icon>mdi-minus</v-icon>
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

        }
    },
    methods : {
        close()
        {
            this.$emit('close4',true)
        },
        deactivate()
        {
            let data = {}
            let req  = axios.put(`/api/dashboard/user/deactivateUser/${this.selected[0].id}`,data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                this.$emit('deactive',true)
            })
            req.catch(err => {
                console.log(err)
            })
        }
    }
}
</script>
