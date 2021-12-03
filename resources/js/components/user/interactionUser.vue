<template>
    <div>
        <v-tabs
            v-model="tab"
            background-color="white"
            centered
            icons-and-text
        >
            <v-tabs-slider></v-tabs-slider>

            <v-tab href="#tab-1">
                Produits
                <v-icon>mdi-package-variant</v-icon>
            </v-tab>

            <v-tab href="#tab-2">
                Demandes de devis
                <v-icon>mdi-hand-heart</v-icon>
            </v-tab>

            <v-tab href="#tab-3">
                Produits favoris
                <v-icon>mdi-heart</v-icon>
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item value="tab-1">
                <product-list-user  />
            </v-tab-item>
            <v-tab-item value="tab-2">
                <request-list-user />
            </v-tab-item>

            <v-tab-item value="tab-3">
                <favorit-products />
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import productListUser from './productListUser'
import requestListUser from './requestListUser'
import favoritProducts from "./favoritProducts"
export default {
   data : () => {
       return{
           tab : null
       }
   },
    components : {
        productListUser,
        requestListUser,
        favoritProducts
    }

}
</script>
