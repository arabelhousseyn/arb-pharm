<template>
    <div>
        <div v-if="requests.length > 0">
            <v-container fluid>
                <v-row>
                    <v-col v-for="(request,index) in requests" :key="index" cols="12" md="4">
                        <v-card class="mx-auto" max-width="344">
                            <v-carousel hide-delimiters>
                                <v-carousel-item
                                    v-for="(image,i) in request.images_request"
                                    :key="i"
                                    :src="image.path"
                                >
                                </v-carousel-item>
                            </v-carousel>

                            <v-card-subtitle>
                                {{ request.product_name }}
                            </v-card-subtitle>

                            <v-card-text>
                                <p><span style="font-weight: bold;">Marque : </span> {{request.mark}} </p>
                                <p><span style="font-weight: bold;">Date creation : </span> {{request.creation_date}} </p>
                                <p><span style="font-weight: bold;" >Crée par</span> : {{request.publishedBy}}</p>
                                <p> <v-chip v-if="request.is_available" color="success" >Disponible</v-chip>
                                    <v-chip v-if="!request.is_available" color="red" ><span style="color: white">Pas Disponible</span> </v-chip>
                                </p>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn @click="remove(request.id)" color="red">
                                    <v-icon>mdi-minus</v-icon>
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
            <no-data />
        </div>
    </div>
</template>

<script>
import dialogComp from "./dialog"
import noData from '../notData'
export default {
    data : () => {
        return {
            id : null,
            open : false,
            overlay : true,
            page : 1,
            requests : [],
            numberPage : 0,
        }
    },
    components : {dialogComp,noData},
    methods : {
        paginate()
        {
            let req  = axios.get(`/api/dashboard/request/getAllRequestsEstimate/?page=${this.page}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                this.requests = e.data.data
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
    },
    created() {
        let req  = axios.get(`/api/dashboard/request/getAllRequestsEstimate`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
        req.then(e=>{
            this.requests = e.data.data
            this.numberPage = e.data.last_page
            this.overlay = false
        })
        req.catch(err => {
            console.log(err)
        })
    }
}
</script>
