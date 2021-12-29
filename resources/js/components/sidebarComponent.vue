<template>
    <div>
        <v-navigation-drawer v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp" app>
            <v-list dense nav>
                <router-link to="/acceuil">
                    <v-list-item link>
                        <v-list-item-icon>
                            <v-icon>mdi-view-dashboard</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Tableau de bord</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </router-link>

                <router-link to="/admin">
                    <v-list-item link>
                        <v-list-item-icon>
                            <v-icon>mdi-account</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Administrateurs</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </router-link>

                <router-link to="/users">
                    <v-list-item link>
                        <v-list-item-icon>
                            <v-icon>mdi-account</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Utilisateurs</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </router-link>

                <router-link to="/products">
                    <v-list-item link>
                        <v-list-item-icon>
                            <v-icon>mdi-package-variant</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Produits</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </router-link>

                <router-link to="/requests">
                    <v-list-item link>
                        <v-list-item-icon>
                            <v-icon>mdi-hand-heart</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Demandes de devis</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </router-link>
            </v-list>
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
