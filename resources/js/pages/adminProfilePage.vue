<template>
    <div>
        <v-container fluid>
            <v-btn @click="back" fab color="primary"> <v-icon color="white">mdi-arrow-left</v-icon> </v-btn>
            <div style="margin-top: 25px;">
                <bread-crumbs />
            </div>
            <div style="margin-top: 35px;">
                        <v-card flat>
                            <form-admin />
                        </v-card>
            </div>

        </v-container>
    </div>
</template>

<script>
import breadCrumbs from '../components/breadcrumbs/breadcrumbs.vue'
import adminTable from "../components/admin/admintable"
import formAdmin from "../components/admin/formadmin";
export default {
    data : () => {
        return{
            tab: null,
        }
    },
    components : {
        breadCrumbs,
        adminTable,
        formAdmin
    },
    methods : {
        back()
        {
            this.$router.push('/admin')
        }
    }
}
</script>

