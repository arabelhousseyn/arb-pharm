<template>
    <div>
        <v-container fluid>
            <v-btn @click="back" fab color="primary"> <v-icon color="white">mdi-arrow-left</v-icon> </v-btn>
            <div style="margin-top: 25px;">
                <bread-crumbs />
            </div>
            <div style="margin-top: 35px;">
                <v-row>

                    <v-col xl="6" lg="6" md="6" sm="12">
                        <v-card>
                            <v-card-title>
                                Informations personnelle
                            </v-card-title>
                            <update-profile-user v-if="!overlay" :data="data" />
                        </v-card>
                    </v-col>

                    <v-col xl="6" lg="6" md="6" sm="12">
                        <v-card>
                            <v-card-title>
                                Informations générales
                            </v-card-title>
                            <update-user-form v-if="!overlay" :data="data" />
                        </v-card>
                    </v-col>
                    <v-col xl="6" lg="6" md="6" sm="12">
                        <v-card>
                            <v-card-title>
                                Sécurité
                            </v-card-title>
                            <update-user-password />
                        </v-card>
                    </v-col>
                </v-row>
            </div>
            <v-overlay v-if="overlay">
                <v-progress-circular
                    indeterminate
                    size="64"
                ></v-progress-circular>
            </v-overlay>
        </v-container>
    </div>
</template>

<script>
import breadCrumbs from '../components/breadcrumbs/breadcrumbs.vue'
import updateUserForm from '../components/user/updateUserForm'
import updateUserPassword from '../components/user/updateUserPassword'
import updateProfileUser from "../components/user/updateProfileUser"
export default {
    data : () => {
        return{
            tab: null,
            overlay : true,
            data : null,
        }
    },
    components : {
        updateUserPassword,
        breadCrumbs,
        updateUserForm,
        updateProfileUser
    },
    methods : {
        back()
        {
            this.$router.push('/users')
        }
    },
    created() {
        let req = axios.get(`/api/dashboard/user/${this.$route.params.id}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
        req.then(e=>{
            this.data = e.data
            this.overlay = false
        })
        req.catch(err =>{
            console.log(err)
        })
    }
}
</script>

