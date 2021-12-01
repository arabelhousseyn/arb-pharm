<template>
    <form method="post" v-model="valid">
        <v-container>
            <v-row>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="firstname"
                        :rules="nameRules"
                        label="Nom"
                        @keypress="check"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="lastname"
                        :rules="nameRules"
                        label="Prénom"
                        @keypress="check"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="email"
                        :rules="emailRules"
                        label="E-mail"
                        type="email"
                        @keypress="check"
                        required
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="phone"
                        :rules="phoneRules"
                        label="Téléphone"
                        type="phone"
                        @keypress="check"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="password"
                        :rules="passwordRules"
                        label="Mote de passe"
                        type="password"
                        @keypress="check"
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

            <v-btn color="primary" :disabled="disable" @click="handle" >Ajouter
                <v-progress-circular v-if="isLoading" indeterminate></v-progress-circular>
                <v-icon v-else>mdi-plus</v-icon>
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
        disable : true,
        isLoading : false,
        firstname: '',
        lastname: '',
        snackbar : false,
        hiddenAlert : true,
        errors : [],
        nameRules: [
            v => !!v || 'champ requis',
        ],
        email: '',
        emailRules: [
            v => !!v || 'E-mail requis',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        phone: '',
        phoneRules: [
            v => !!v || 'Téléphone requis',
        ],
        password: '',
        passwordRules: [
            v => !!v || 'Mote de passe requis',
        ],
    }),
    methods : {
        hide(){
            this.hiddenAlert = true
        },
        handle()
        {
            this.disable = true
            this.isLoading = true
            let data = {
                fname : this.firstname,
                lname : this.lastname,
                phone : this.phone,
                email : this.email,
                password : this.password
            }
            let req  = axios.post('/api/dashboard/admin',data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                if (e.status == 201) {
                    this.disable = false
                    this.isLoading = false
                    this.firstname = ''; this.lastname = '';this.email = '';this.phone = '';this.password = '';
                    this.valid = true;
                    this.snackbar = true
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
                    this.disable = false
                    this.isLoading = false
                    this.valid = false
                }
            })
        },
        check()
        {
            if(this.firstname.length == 0 || this.lastname.length == 0 || this.email.length == 0
                || this.phone.length == 0 || this.password.length == 0)
            {
                this.disable = true
            }else{
                this.disable = false
            }
        }
    },
    components : {
        snackBar
    }
}
</script>
