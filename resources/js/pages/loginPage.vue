<template>
    <div class="login">
         <v-app>
    <v-main>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center" dense>
          <v-col cols="12" sm="8" md="4" lg="4">
            <v-card elevation="0">
              <a href="#" name="Fedorae Education" title="Fedorae Education" target="_blank">
                <v-img src="assets/pharm.png" alt="Eurl ARB PHARM" contain height="100"></v-img>
              </a>
              <v-card-text>
                <v-form ref="form" method="POST" action='/login'>
                <input type="hidden" name="_token" :value="data.csrf">
                  <v-text-field label="email *" @keypress.esc="valaidation"  @keypress="valaidation" v-model="data.email" :rules="rules.emailRules" name="email" prepend-inner-icon="mdi-email" type="text" class="rounded-0" outlined required></v-text-field>
                  <v-text-field label="password *" @keypress.esc="valaidation" @keypress="valaidation" v-model="data.password" :rules="rules.passwordRules" name="password" prepend-inner-icon="mdi-password" type="password" class="rounded-0" outlined required></v-text-field>
                  <v-btn class="rounded-0" type="submit" :disabled='valid' @click="validate" color="#36A9E1" x-large block :dark='!valid'>Connexion</v-btn>
                </v-form>
              </v-card-text>
              <v-card-actions class="ml-6 mr-6 text-center">
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
    </div>
</template>

<script>
export default {
    data : () => {
        return{
            valid: true,
            data : {
                email : '',
                password : '',
                csrf: ''
            },
            rules : {
                emailRules : [
                   v => !!v || 'e-mail est requis',
                   v => /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                ],
                passwordRules : [
                   v => !!v || 'mot de passe est requis',
                   v => /.+\..+/.test(v) || 'le mot de passe doit être valide',
                ]
            }
        }
    },
    methods : {
        validate () {
          this.valid = false
        this.$refs.form.validate()
      },
      valaidation()
      {
         if(this.data.email.length !== 0 && this.data.password.length !== 0)
         {
             this.valid = false
         }

         if(this.data.email.length == 0 || this.data.password.length == 0)
         {
             this.valid = true
         }
      }
    },
    components : {

    },
    created()
    {
        this.data.csrf = document.head.querySelector('meta[name="csrf-token"]').content
    }
}
</script>
