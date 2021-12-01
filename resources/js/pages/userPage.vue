<template>
    <div>
        <v-container fluid>
            <bread-crumbs />
            <div style="margin-top: 35px;">
                <v-tabs v-model="tab" align-with-title >
                    <v-tabs-slider color="blue"></v-tabs-slider>
                    <v-tab>
                        <span>Acceuil <v-icon>mdi-home</v-icon> </span>
                    </v-tab>
                    <v-tab>
                        <span>Ajouté utilisateur <v-icon>mdi-plus</v-icon> </span>
                    </v-tab>
                </v-tabs>
                <v-tabs-items v-model="tab">
                    <v-tab-item>
                        <v-card flat>
                            <user-table />
                        </v-card>
                    </v-tab-item>

                    <v-tab-item>
                        <v-card flat>
                            <form-user />
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
            </div>

        </v-container>
    </div>
</template>

<script>
import breadCrumbs from '../components/breadcrumbs/breadcrumbs.vue'
import userTable from "../components/user/usertable"
import formUser from "../components/user/formuser"
export default {
    data : () => {
        return{
            tab: null,
        }
    },
    components : {
        breadCrumbs,
        userTable,
        formUser
    }
}
</script>

