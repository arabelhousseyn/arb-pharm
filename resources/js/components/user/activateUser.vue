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

                <v-menu
                    v-model="menu2"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="date"
                            label="Date d'expiration"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        :min="min"
                        v-model="date"
                        @input="menu2 = false"
                    ></v-date-picker>
                </v-menu>

                <v-select
                    prepend-icon="mdi-form-select"
                    @change="check"
                    v-model="type"
                    :items="select2"
                    label="Catégorie"
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
                    <v-progress-circular indeterminate color="primary" v-if="isloading"></v-progress-circular>
                    <span v-else>Activé <v-icon>mdi-power</v-icon></span>
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
            type : null,
            isloading : false,
            date: (new Date()).toISOString().substr(0, 10),
            menu2: false,
            select2: [
                { text: 'A' },
                { text: 'R' },
                { text: 'B' },
            ],
            min : (new Date()).toISOString().substr(0, 10),
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
            this.isloading = true
            let data = {
                date : this.date,
                type : this.type
            }
            console.log(data)
            let req  = axios.put(`/api/dashboard/user/activateUser/${this.selected[0].id}`,data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                this.$emit('active',true)
                this.disable = true
                this.isloading = false
            })
            req.catch(err => {
                console.log(err)
            })
        }
    }
}
</script>
