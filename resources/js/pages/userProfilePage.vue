<template>
    <div>
        <v-container fluid>
            <v-btn @click="back" fab color="primary"> <v-icon color="white">mdi-arrow-left</v-icon> </v-btn>
            <div style="margin-top: 25px;">
                <bread-crumbs />
            </div>
            <div style="margin-top: 35px;">
                <v-row>
                    <v-col cols="12" md="4">
                        <v-card>
                            <card-profile :name="data.profile_name" v-if="!overlay" />
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="8">
                        <v-card>
                            <info-table-user :code="data.code" :info="data.get_profile" v-if="!overlay" />
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="12">
                        <v-card>
                            <v-card-title>
                                Paiment
                            </v-card-title>
                            <payment-user :payments="data.payments" v-if="!overlay" />
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="12">
                        <v-card elevation="0">
                            <interaction-user :products="data.products" :favorites="data.favorites" :requests="data.requests" v-if="!overlay" />
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
import cardProfile from "../components/user/cardProfile"
import infoTableUser from "../components/user/infotableUser"
import interactionUser from "../components/user/interactionUser"
import paymentUser from "../components/user/paymentUser"
export default {
    data : () => {
        return{
            tab: null,
            overlay : true,
            data : null,
        }
    },
    components : {
        breadCrumbs,
        cardProfile,
        infoTableUser,
        interactionUser,
        paymentUser
    },
    methods : {
        back()
        {
            this.$router.push('/users')
        }
    },
    created() {
        let req = axios.get(`/api/dashboard/user/profileInfo/${this.$route.params.id}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
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

