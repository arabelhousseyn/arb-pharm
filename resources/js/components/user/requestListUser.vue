<template>
    <div>
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
                                <p> <v-chip v-if="request.is_available" color="success" >Disponible</v-chip>
                                    <v-chip v-if="!request.is_available" color="red" ><span style="color: white">Pas Disponible</span> </v-chip>
                                </p>
                            </v-card-text>

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
            requests : [],
            numberPage : 0,
        }
    },
    methods : {
        paginate()
        {
            let req  = axios.get(`/api/dashboard/request/getRequestEstimateByUser/${this.$route.params.id}?page=${this.page}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
            req.then(e=>{
                this.requests = e.data.data
            })
            req.catch(err => {
                console.log(err)
            })
        }
    },
    created() {
        let req  = axios.get(`/api/dashboard/request/getRequestEstimateByUser/${this.$route.params.id}`,{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
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
