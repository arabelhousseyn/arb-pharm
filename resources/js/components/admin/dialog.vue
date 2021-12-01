<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            max-width="290"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Suppression
                </v-card-title>

                <v-card-text>
                    si vous êtes sûr de supprimer appuyer sur <span style="font-weight: bold">accepter</span> sinon <span style="font-weight: bold">annuler</span>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="handle2"
                        :disabled="isloading"
                    >
                        Annuler
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="handle"
                    >
                        <v-progress-circular indeterminate color="primary" v-if="isloading"></v-progress-circular>
                        <span v-else>Accepter</span>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
export default {
    props : ['dialog','selected'],
    data () {
        return {
            isloading : false
        }
    },
    methods : {
       async handle()
        {
            this.isloading = true
            for (let selected of this.selected) {
                let req  = axios.delete(`/api/dashboard/admin/${selected.id}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
                await req.then(e=>{
                    this.$store.commit('SET_INFOS',e.data)
                })
                req.catch(err => {
                    console.log(err)
                })
            }

            this.$emit('close',true)
            this.isloading = false
        },
         handle2()
        {
            this.$emit('close',true)
            this.isloading = false
        }
    }
}
</script>
