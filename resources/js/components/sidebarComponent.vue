<template>
    <div>
        <v-navigation-drawer v-model="drawer"
                             :clipped="$vuetify.breakpoint.lgAndUp" app>
            <v-list dense>
                <v-list-item-group color="primary">
                    <v-list-item to="/accueil" class="mb-3">
                        <v-list-item-icon>
                            <v-icon>mdi-view-dashboard-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Accueil</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/users" class="mb-3">
                        <v-list-item-icon>
                            <v-icon>mdi-account-multiple-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Utilisateurs</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
            <template v-slot:append>
                <div class="pa-2 elevation-1" style="text-align: center">
                    <v-btn smal text fab icon >
                        <v-icon>mdi-logout</v-icon>
                    </v-btn>
                    <v-btn smal text fab icon to="/my-account">
                        <v-icon>mdi-account-outline</v-icon>
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <appbar-component @toggle="toggle" />
        <v-overlay :value="overlay" opacity="1" color="white">
            <v-progress-circular indeterminate size="50" color="primary" width="8"></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
import appbarComponent from "./appbarComponent";
export default {
    data() {
        return {
            drawer: null,
            overlay: false,
            APP_NAME: 'arb',
        }
    },
    components : {
        appbarComponent
    },
    methods: {
        toggle()
        {
            this.drawer = !this.drawer
        }
    },

}
</script>
