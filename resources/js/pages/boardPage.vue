<template>
    <div>
        <v-breadcrumbs
            style="font-weight: bold;"
        ><h2>Admin panel</h2></v-breadcrumbs>
        <v-container fluid>
            <v-row>
                <v-col v-for="(card,index) in $store.state.cards" :key="index"  lg="3" cols="12" md="3">
                    <cardComponent :value="card.value" :color="card.color" :title="card.title" :icon="card.icon" />
                </v-col>
                <v-col lg="12" cols="12" md="12">
                    <v-card>
                        <v-card-text>
                            <line-chart />
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
import cardComponent from '../components/cardComponent'
import lineChart from "../components/chart/lineChart";
 export default {
         components : {
             cardComponent,
             lineChart
         }
 }

</script>
