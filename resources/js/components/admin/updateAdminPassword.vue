<template>
    <form method="post" v-model="valid">
        <v-container>
            <v-row>
                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="data.old_password"
                        label="Ancien mote de passe"
                        type="password"
                        :rules="passwordRule"
                        @keypress="check"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="data.new_password"
                        label="Nouveaux mote de passe"
                        type="password"
                        @keypress="check"
                        :rules="passwordRule"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="data.re_new_password"
                        label="Entrez à nouveau mote de passe"
                        type="password"
                        @keypress="check"
                        :rules="passwordRule"
                        required
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-alert
                :hidden="hiddenAlert"
                prominent
                type="error"
            >
                <v-row align="center">
                    <v-col class="grow">
                        <ul>
                            <li v-for="(error,index) in errors" :key="index">
                                {{ error }}
                            </li>
                        </ul>
                    </v-col>
                    <v-col class="shrink">
                        <v-btn @click="hide">Fermer</v-btn>
                    </v-col>
                </v-row>
            </v-alert>

            <v-btn color="success" :disabled="disable" @click="handle" >Modifier
                <v-progress-circular v-if="isLoading" indeterminate></v-progress-circular>
                <v-icon v-else>mdi-wrench</v-icon>
            </v-btn>
            <snack-bar :snackbar="snackbar" />
        </v-container>
    </form>
</template>

<script>
import snackBar from "../snackbar/snackbar";
export default {
    data: () => ({
        valid: false,
        isLoading : false,
        snackbar : false,
        hiddenAlert : true,
        errors : [],
        data : {
            old_password : '',
            new_password : '',
            re_new_password : '',
        },
        disable : true,
        passwordRule: [
            v => !!v || 'Champ requis',
        ],
    }),
    methods : {
        hide(){
            this.hiddenAlert = true
        },
        check()
        {
            this.disable = (this.data.old_password.length == 0 || this.data.new_password.length == 0
             || this.data.re_new_password.length == 0) ? true : false
        },
        handle()
        {
            this.disable = true
            this.isLoading = true
            let req  = axios.put(`/api/dashboard/admin/changePassword/${this.$route.params.id}`,this.data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                if (e.status == 200) {
                    this.disable = false
                    this.isLoading = false
                    this.valid = true;
                    this.snackbar = true
                    this.data.old_password = ''; this.data.new_password = '';this.data.re_new_password = ''
                    setTimeout(()=> {
                        this.snackbar = false
                    },1000)
                }
            })
            req.catch(err => {
                if(err.response.status == 422)
                {
                    this.errors = []
                    this.hiddenAlert = false
                    let errors = err.response.data.errors
                    for (var error in errors) {
                        let temp = errors[error]
                        for (let i = 0;i<temp.length;i++)
                        {
                            this.errors.push(temp[i])
                        }
                    }
                    this.disable = true
                    this.isLoading = false
                    this.data.old_password = ''; this.data.new_password = '';this.data.re_new_password = ''
                    this.valid = false
                }
            })
        },
    },
    components : {
        snackBar
    },
}
</script>
