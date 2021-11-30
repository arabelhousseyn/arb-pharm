<template>
    <div class="card">
        <v-card>
            <v-card-title>
                <span class="text--secondary" style="font-size: 15px">{{ title }}</span>
                <v-spacer></v-spacer>
                <v-avatar color="#00b9e5" width="66" height="66">
                    <v-icon color="white" large>{{ icon }}</v-icon>
                </v-avatar>
            </v-card-title>
            <v-card-subtitle>
                <span >{{ value }}</span>
            </v-card-subtitle>
        </v-card>
    </div>
</template>

<script>
   export  default {
       props : ['color','title','icon','value']
   }
</script>
