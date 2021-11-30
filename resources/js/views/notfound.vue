<template>
    <div style="margin-top: 50px;">
        <v-row justify="center">
            <router-link to="/acceuil"><v-btn color="primary" fab><v-icon>mdi-arrow-left</v-icon> </v-btn></router-link>
            <h1>404 NOT FOUND</h1>
        </v-row>
        <v-row justify="center" align="center">
            <v-card>
                <v-img aspect-ratio="1" class="grey lighten-2" width="500" height="500" lazy-src="../assets/notfound.gif" src="../assets/notfound.gif">
                    <template v-slot:placeholder>
                        <v-row
                            class="fill-height ma-0"
                            align="center"
                            justify="center"
                        >
                            <v-progress-circular
                                indeterminate
                                color="grey lighten-5"
                            ></v-progress-circular>
                        </v-row>
                    </template>
                </v-img>
            </v-card>
        </v-row>
    </div>
</template>
