<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="4">
                <v-card
                    class="mx-auto"
                    max-width="344"
                >
                    <v-carousel hide-delimiters>
                        <v-carousel-item
                            v-for="(item,i) in items"
                            :key="i"
                            :src="item.src"
                        ></v-carousel-item>
                    </v-carousel>

                    <v-card-title>
                        Top western road trips
                    </v-card-title>

                    <v-card-subtitle>
                        1,000 miles of wonder
                    </v-card-subtitle>

                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card
                    class="mx-auto"
                    max-width="344"
                >
                    <v-carousel hide-delimiters>
                        <v-carousel-item
                            v-for="(item,i) in items"
                            :key="i"
                            :src="item.src"
                        ></v-carousel-item>
                    </v-carousel>

                    <v-card-title>
                        Top western road trips
                    </v-card-title>

                    <v-card-subtitle>
                        1,000 miles of wonder
                    </v-card-subtitle>

                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card
                    class="mx-auto"
                    max-width="344"
                >
                    <v-carousel hide-delimiters>
                        <v-carousel-item
                            v-for="(item,i) in items"
                            :key="i"
                            :src="item.src"
                        ></v-carousel-item>
                    </v-carousel>

                    <v-card-title>
                        Top western road trips
                    </v-card-title>

                    <v-card-subtitle>
                        1,000 miles of wonder
                    </v-card-subtitle>

                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card
                    class="mx-auto"
                    max-width="344"
                >
                    <v-carousel hide-delimiters>
                        <v-carousel-item
                            v-for="(item,i) in items"
                            :key="i"
                            :src="item.src"
                        ></v-carousel-item>
                    </v-carousel>

                    <v-card-title>
                        Top western road trips
                    </v-card-title>

                    <v-card-subtitle>
                        1,000 miles of wonder
                    </v-card-subtitle>

                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
 export default {
     props :['products'],
     data : () => {
         return {
             items: [
                 {
                     src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                 },
                 {
                     src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
                 },
                 {
                     src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
                 },
                 {
                     src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
                 },
             ],
         }
     },
 }
</script>
