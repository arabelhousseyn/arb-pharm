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

         if(this.$route.path.includes('admin'))
         {
             let info = [
                 {
                     text: 'Admin panel',
                     href: 'acceuil',
                 },
                 {
                     text: 'Administrateurs',
                     href: '/admin',
                 }
             ]
             this.items = info
         }

         if(this.$route.path.includes('admin/update') || this.$route.path.includes('profile'))
         {
             let info = [
                 {
                     text: 'Admin panel',
                     href: '/acceuil',
                 },
                 {
                     text: 'Administrateurs',
                     href: '/admin',
                 },
                 {
                     text: 'Modifier administrateur',
                     disabled : true,
                     href: '/admin',
                 }
             ]
             this.items = info
         }

         // users

         if(this.$route.path.includes('users'))
         {
             let info = [
                 {
                     text: 'Admin panel',
                     href: 'acceuil',
                 },
                 {
                     text: 'Utilisateurs',
                     href: '/users',
                 }
             ]
             this.items = info
         }

         if(this.$route.path.includes('users/update'))
         {
             let info = [
                 {
                     text: 'Admin panel',
                     href: 'acceuil',
                 },
                 {
                     text: 'Utilisateurs',
                     href: '/users',
                 },
                 {
                     text: 'Modifier utilisateur',
                     disabled : true,
                     href: 'admin',
                 }
             ]
             this.items = info
         }

         if(this.$route.path.includes('users/profile'))
         {
             let info = [
                 {
                     text: 'Admin panel',
                     href: 'acceuil',
                 },
                 {
                     text: 'Utilisateurs',
                     href: '/users',
                 },
                 {
                     text: 'Profile',
                     disabled : true,
                     href: '/users',
                 }
             ]
             this.items = info
         }

         if(this.$route.path.includes('users/history'))
         {
             let info = [
                 {
                     text: 'Admin panel',
                     href: 'acceuil',
                 },
                 {
                     text: 'Utilisateurs',
                     href: '/users',
                 },
                 {
                     text: 'Historique d\'abonnement',
                     disabled : true,
                     href: '/users',
                 }
             ]
             this.items = info
         }

         if(this.$route.path.includes('products'))
         {
             let info = [
                 {
                     text: 'Admin panel',
                     href: 'acceuil',
                 },
                 {
                     text: 'Produits',
                     href: '/products',
                 }
             ]
             this.items = info
         }

         if(this.$route.path.includes('requests'))
         {
             let info = [
                 {
                     text: 'Admin panel',
                     href: 'acceuil',
                 },
                 {
                     text: 'Demandes de devis',
                     href: '/requests',
                 }
             ]
             this.items = info
         }

     }
 }
</script>
