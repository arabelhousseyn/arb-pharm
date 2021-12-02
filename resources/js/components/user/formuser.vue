<template>
    <form method="post" v-model="valid">
        <v-card elevation="0">
            <v-card-title>Informations générales</v-card-title>
            <v-container>
                <v-row>
                    <v-col
                        cols="12"
                        md="6"
                    >
                        <v-text-field
                            v-model="data.email"
                            :rules="emailRules"
                            label="E-mail *"
                            type="email"
                            @keypress="check"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="6"
                    >
                        <v-text-field
                            v-model="data.phone"
                            :rules="phoneRules"
                            label="Téléphone *"
                            type="phone"
                            @keypress="check"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col
                        cols="12"
                        md="6"
                    >
                        <v-text-field
                            v-model="data.password"
                            :rules="passwordRules"
                            label="Mote de passe *"
                            type="password"
                            @keypress="check"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
        <v-divider></v-divider>
        <v-card elevation="0">
            <v-card-title>Information personnelle</v-card-title>
            <v-container>
                <v-row>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field
                            v-model="data.commercial_name"
                            :rules="commercialNameRules"
                            label="Nom commercial *"
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
                            v-model="data.nif"
                            :rules="nifRules"
                            label="Nif *"
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
                            v-model="data.nis"
                            :rules="nisRules"
                            label="Nis *"
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
                            v-model="data.num_ar"
                            :rules="numArRules"
                            label="Numéro AR *"
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
                            v-model="data.pro_card"
                            :rules="proCardRules"
                            label="Carte professionelle *"
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
                            v-model="data.adress"
                            :rules="adressRules"
                            label="Adresse *"
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
                            v-model="data.activity_code"
                            :rules="activityCodeRules"
                            label="Code d'activité *"
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
                            v-model="data.num_rc"
                            :rules="numRcRules"
                            label="Numéro de RC *"
                            type="phone"
                            @keypress="check"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
        <v-divider></v-divider>
        <v-card elevation="0">
            <v-card-title>Paiment</v-card-title>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-file-input
                            accept="image/png, image/jpeg, image/png"
                            placeholder="Choisissez une image"
                            prepend-icon="mdi-camera"
                            label="Paiment"
                            @change="check"

                            v-model="data.tempimages"
                            multiple
                        ></v-file-input>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>


        <v-container fluid>

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
        snackbar : false,
        hiddenAlert : true,
        errors : [],
        data : {
            phone : '',
            email : '',
            password : '',
            commercial_name : '',
            nis : '',
            nif : '',
            num_ar : '',
            pro_card : '',
            adress : '',
            activity_code : '',
            num_rc : '',
            tempimages : [],
            images : []
        },
        emailRules: [
            v => !!v || 'E-mail requis',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        phoneRules: [
            v => !!v || 'Téléphone requis',
        ],
        passwordRules: [
            v => !!v || 'Mote de passe requis',
        ],
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

             for  (const image of this.data.tempimages) {
                   this.converter(image)
            }

              setTimeout(()=> {
                  console.log(this.data.images)
                 this.data.images = this.data.images.join(';')

                  let req  = axios.post('/api/dashboard/user',this.data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
                  req.then(e=>{
                      if (e.status == 201) {
                          this.disable = false
                          this.isLoading = false
                          this.data.phone = ''; this.data.activity_code = ''; this.data.images = [];
                          this.data.nif = '';this.data.nis = '';this.data.adress = '';
                          this.data.commercial_name = '';this.data.email = '';this.data.num_ar = '';
                          this.data.password = '';this.data.phone = '';
                          this.data.pro_card = ''; this.data.tempimages = [];
                          this.data.num_rc = '';
                          this.valid = true;
                          this.snackbar = true
                          setTimeout(()=> {
                              this.snackbar = false
                              location.reload()
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
                          this.data.images = []
                          this.data.tempimages = []
                          this.disable = false
                          this.isLoading = false
                          this.valid = false
                      }
                  })

             },10000)
        },
          converter(image)
        {
            const reader = new FileReader()

            let rawImg;
              reader.onloadend =  (e) => {
                rawImg = e.target.result;
                this.data.images.push(rawImg.replace(/^data:image\/(png|jpg|jpeg);base64,/, ''))
            }
            reader.readAsDataURL(image);
        },
        check()
        {
            this.disable = (this.data.phone.length == 0 || this.data.activity_code.length == 0 ||
            this.data.tempimages.length == 0 || this.data.nif.length == 0 || this.data.nis.length == 0 ||
             this.data.adress.length == 0 || this.data.commercial_name.length == 0 ||
            this.data.email.length == 0 || this.data.num_ar.length == 0 || this.data.password.length == 0 ||
            this.data.phone.length == 0 || this.data.num_rc.length == 0 || this.data.pro_card.length == 0) ? true : false
        }
    },
    components : {
        snackBar
    }
}
</script>
