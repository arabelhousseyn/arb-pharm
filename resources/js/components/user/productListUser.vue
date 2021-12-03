<template>
    <div>
        <v-container fluid>
            <v-row>
                <v-col v-for="(product,index) in products" :key="index" cols="12" md="4">
                    <v-card class="mx-auto" max-width="344">
                        <v-carousel hide-delimiters>
                            <v-carousel-item
                                v-for="(image,i) in product.images"
                                :key="i"
                                :src="image.path"
                            >
                            </v-carousel-item>
                        </v-carousel>

                        <v-card-subtitle>
                            {{ product.description }}
                        </v-card-subtitle>

                        <v-card-text>
                            <span style="font-weight: bold;" >Date creation</span> : {{product.creation_date}}
                        </v-card-text>

                        <v-card-actions>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                            <v-btn  v-bind="attrs" v-on="on" @click="download(product.technical_sheet_pdf)" color="#F40F02">
                                <v-icon color="white">mdi-file-download</v-icon>
                            </v-btn>
                                </template>
                                <span>Fiche technique</span>
                            </v-tooltip>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-container style="text-align: center;" fluid>
            <div class="text-center">
                <v-pagination
                    @input="paginate"
                    v-model="page"
                    :length="numberPage"
                    circle
                    :total-visible="7"
                ></v-pagination>
            </div>
        </v-container>
        <v-overlay v-if="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
 export default {
     data : () => {
         return {
             overlay : true,
             page : 1,
             products : [],
             numberPage : 0,
         }
     },
     methods : {
       paginate()
       {
           let req  = axios.get(`/api/dashboard/product/getProductsByUser/${this.$route.params.id}?page=${this.page}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
           req.then(e=>{
               this.products = e.data.data
           })
           req.catch(err => {
               console.log(err)
           })
       },
         download(url)
         {
             window.open(url,'Download')
         }
     },
     created() {
         let req  = axios.get(`/api/dashboard/product/getProductsByUser/${this.$route.params.id}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
         req.then(e=>{
             this.products = e.data.data
             this.numberPage = e.data.last_page
             this.overlay = false
         })
         req.catch(err => {
             console.log(err)
         })
     }
 }
</script>
