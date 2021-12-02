<template>
    <form method="post" v-model="valid">
        <v-container>
            <v-row>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="data.get_profile.commercial_name"
                        :rules="commercialNameRules"
                        label="Nom commercial *"
                        type="email"
                        required
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="data.get_profile.nif"
                        :rules="nifRules"
                        label="Nif *"
                        type="phone"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="data.get_profile.nis"
                        :rules="nisRules"
                        label="Nis *"
                        type="phone"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="data.get_profile.num_ar"
                        :rules="numArRules"
                        label="Numéro AR *"
                        type="phone"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="data.get_profile.pro_card"
                        :rules="proCardRules"
                        label="Carte professionelle *"
                        type="phone"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="data.get_profile.adress"
                        :rules="adressRules"
                        label="Adresse *"
                        type="phone"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="data.code"
                        :rules="activityCodeRules"
                        label="Code d'activité *"
                        type="phone"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="data.get_profile.num_rc"
                        :rules="numRcRules"
                        label="Numéro de RC *"
                        type="phone"
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
        commercialNameRules: [
            v => !!v || 'Nom commercial requis',
        ],
        nisRules: [
            v => !!v || 'Nis requis',
        ],
        nifRules: [
            v => !!v || 'Nif requis',
        ],
        numArRules: [
            v => !!v || 'Numéro AR requis',
        ],
        proCardRules: [
            v => !!v || 'Carte professionelle requis',
        ],
        adressRules: [
            v => !!v || 'Adresse requis',
        ],
        activityCodeRules: [
            v => !!v || 'Code d\'activité requis',
        ],
        numRcRules: [
            v => !!v || 'Numéro de RC requis',
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
                commercial_name : this.data.get_profile.commercial_name,
                adress : this.data.get_profile.adress,
                nif : this.data.get_profile.nif,
                nis : this.data.get_profile.nis,
                num_ar : this.data.get_profile.num_ar,
                num_rc : this.data.get_profile.num_rc,
                pro_card : this.data.get_profile.pro_card,
                activity_code : this.data.code
            }

            let req  = axios.put(`/api/dashboard/user/updateProfileUser/${this.data.id}`,data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
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
