<template>
    <div class="profile">
            <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :nudge-width="200"
      offset-x
    >
      <template v-slot:activator="{ on, attrs }">
        <v-list-item-avatar v-bind="attrs"
          v-on="on">
          <v-img src="../assets/profile.png"></v-img>
        </v-list-item-avatar>
      </template>

      <v-card>
        <v-list>
          <v-list-item>
            <v-list-item-avatar>
              <v-img src="../assets/profile.png"></v-img>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>{{this.$store.state.fullName}} </v-list-item-title>
              <v-list-item-subtitle>Admin</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list>
          <v-list-item>
            <v-list-item-action>
              <v-switch
                v-model="dark"
                color="black"
              ></v-switch>
            </v-list-item-action>
            <v-list-item-title>Activer le mode sombre</v-list-item-title>
          </v-list-item>
        </v-list>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="danger"
            text
            @click="logout"
          >
            Se déconnecter
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>
    </div>
</template>

<script>
export default {
    data : () => {
        return{
      menu: false,
      dark: false,
        }
    },
    methods : {
      logout()
      {
        this.menu = false
      }
    }
}
</script>