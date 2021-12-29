<template>
    <div>
        <v-row>
            <v-col cols="12" md="6" sm="12">
                <v-card>
                    <v-card-title>Modifier chèquier</v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="update">
                            <v-text-field
                                v-model="data.book_number"
                                :rules="booknumberRules"
                                label="Numéro du cheque *"
                                type="text"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="data.book_key_number"
                                :rules="bookkeynumberRules"
                                label="Clé du cheque *"
                                type="text"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="data.fullName"
                                :rules="fullNameRules"
                                label="Nom Complete *"
                                type="text"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="data.adress"
                                :rules="adressRules"
                                label="Adresse *"
                                type="text"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="data.phone"
                                :rules="phoneRules"
                                label="Téléphone *"
                                type="text"
                                required
                            ></v-text-field>
                            <v-btn type="submit" :disabled="!progress" class="success">Modifier <v-progress-circular v-if="!progress" indeterminate size="25"></v-progress-circular></v-btn>
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
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12">
                <v-card>
                    <v-card-title>Information chèquier</v-card-title>
                    <v-card-text>
                        <v-simple-table>
                            <template v-slot:default>
                                <tbody>
                                <tr>
                                    <td><span class="font-weight-bold"> Numéro du cheque </span></td>
                                    <td>{{data.book_number}}</td>
                                </tr>
                                <tr>
                                    <td><span class="font-weight-bold"> Clé du cheque </span></td>
                                    <td>{{data.book_key_number}}</td>
                                </tr>
                                <tr>
                                    <td><span class="font-weight-bold"> Nom Complete </span></td>
                                    <td>{{data.fullName}}</td>
                                </tr>
                                <tr>
                                    <td><span class="font-weight-bold"> Adresse </span></td>
                                    <td>{{data.adress}}</td>
                                </tr>
                                <tr>
                                    <td><span class="font-weight-bold"> Téléphone </span></td>
                                    <td>{{data.phone}}</td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
        <Snackbar :snackbar="snackbar" />
    </div>
</template>

<script>
import Snackbar from "../snackbar/snackbar";
export default {
    components: {Snackbar},
    data : () =>{
        return{
          data : [],
            errors : [],
            progress : true,
            hiddenAlert : true,
            overlay: true,
            snackbar : false,
            booknumberRules: [
                v => !!v || 'Numéro du cheque requis',
            ],
            bookkeynumberRules: [
                v => !!v || 'Clé du cheque requis',
            ],
            fullNameRules: [
                v => !!v || 'Nom Complete requis',
            ],
            adressRules: [
                v => !!v || 'Adresse requis',
            ],
            phoneRules: [
                v => !!v || 'Téléphone requis',
            ],
        }
    },
    methods : {
      update()
      {
          this.progress = false
          let req = axios.put(`/api/dashboard/checkbook/${this.data.id}`,this.data,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
          req.then(e=>{
             this.snackbar = true
             this.progress = true
              setTimeout(()=>{
                  this.snackbar = false
              },2000)
          })
          req.catch(err => {
              this.hiddenAlert = false
              this.progress = true
              this.errors = []
              let errors = err.response.data.errors
              for (var error in errors) {
                  let temp = errors[error]
                  for (let i = 0;i<temp.length;i++)
                  {
                      this.errors.push(temp[i])
                  }
              }
          })
      },
        hide(){
            this.hiddenAlert = true
        },
    },
    created() {
        let req = axios.get('/api/dashboard/checkbook/',{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
        req.then(e=>{
            this.data = e.data
            this.overlay = false
        })
        req.catch(err=>{
            console.log(err)
        })
    }
}
</script>
