<template>
    <div>
        <v-card>
            <v-card-text>
                <v-breadcrumbs
                    :items="items"
                    divider=">"
                ></v-breadcrumbs>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
 export default {
     data: () => ({
         items: [],
     }),
     created() {
         switch (this.$route.path)
         {
             case '/admin' :
                 let info = [
                     {
                         text: 'Admin panel',
                         href: 'acceuil',
                     },
                     {
                         text: 'admin',
                         href: 'admin',
                     }
                 ]
                 this.items = info
                 break;
         }
     }
 }
</script>
