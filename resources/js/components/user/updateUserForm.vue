<template>
    <form method="post" v-model="valid">
        <v-container>
            <v-row>
                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="data.email"
                        label="E-mail"
                        type="email"
                        required
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="data.phone"
                        label="Téléphone"
                        type="phone"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="6"
                >
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

            <v-btn color="success" @click="handle" >Modifier
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
    props : ['data'],
    data: () => ({
        valid: false,
        isLoading : false,
        snackbar : false,
        hiddenAlert : true,
        errors : [],
    }),
    methods : {
        hide(){
            this.hiddenAlert = true
        },
        handle()
        {
            this.disable = true
            this.isLoading = true
            let req  = axios.put(`/api/dashboard/user/${this.data.id}`,this.data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                if (e.status == 200) {
                    this.isLoading = false
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
                    this.isLoading = false
                    this.valid = false
                }
            })
        },
    },
    components : {
        snackBar
    },
    created() {
    }
}
</script>
