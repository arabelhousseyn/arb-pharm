<template>
<div>
    <div v-if="products.length > 0">
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
                            <p><span style="font-weight: bold;" >Date creation</span> : {{product.creation_date}}</p>
                            <p><span style="font-weight: bold;" >Crée par</span> : {{product.published_by}}</p>
                        </v-card-text>

                        <v-card-actions>
                            <v-btn  @click="download(product.technical_sheet_pdf)" color="#F40F02">
                                <v-icon color="white">mdi-file-download</v-icon>
                            </v-btn>

                            <v-btn @click="remove(product.id)" color="red">
                                <v-icon color="white">mdi-minus</v-icon>
                            </v-btn>
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
        <dialogComp :dialog="open" :id="id" v-on:close="close" v-on:close2="close2" />
    </div>
    <div v-else>
        <not-data/>
    </div>
</div>
</template>

<script>
import dialogComp from "./dialog"
import noData from '../notData'
import NotData from "../notData";
export default {
    data : () => {
        return {
            id : null,
            open : false,
            overlay : true,
            page : 1,
            products : [],
            numberPage : 0,
        }
    },
    components : {NotData, dialogComp},
    methods : {
        paginate()
        {
            let req  = axios.get(`/api/dashboard/product/getAllProducts/?page=${this.page}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                this.products = e.data.data
            })
            req.catch(err => {
                console.log(err)
            })
        },
        remove(id)
        {
            this.id = id
            this.open = true
        },
        close(val)
        {
            location.reload()
        },
        close2()
        {
            this.open = false
        },
    download(url)
    {
        window.open(url,'Download')
    }
    },
    created() {
        let req  = axios.get(`/api/dashboard/product/getAllProducts`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
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
