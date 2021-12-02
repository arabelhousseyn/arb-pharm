<template>
<div>
    <v-container style="text-align: center;" fluid>
        <v-row>
            <v-col
                v-for="(payment,index) in payments"
                :key="index"
                class="d-flex child-flex"
                cols="3"
            >
                <v-img
                    :src="payment.path"
                    :lazy-src="payment.path"
                    aspect-ratio="1"
                    class="grey lighten-2"
                >
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
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
export  default {
    props : ['payments']
}
</script>
