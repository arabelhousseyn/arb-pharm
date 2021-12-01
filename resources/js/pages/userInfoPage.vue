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
                                Informations générales
                            </v-card-title>
                            <update-user-form />
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

        </v-container>
    </div>
</template>

<script>
import breadCrumbs from '../components/breadcrumbs/breadcrumbs.vue'
import updateUserForm from '../components/user/updateUserForm'
import updateUserPassword from '../components/user/updateUserPassword'
export default {
    data : () => {
        return{
            tab: null,
        }
    },
    components : {
        updateUserPassword,
        breadCrumbs,
        updateUserForm,

    },
    methods : {
        back()
        {
            this.$router.push('/users')
        }
    },
    created() {

    }
}
</script>

