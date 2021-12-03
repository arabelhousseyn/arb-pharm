 <template>
    <div>
        <v-menu
            v-model="menu"
            :close-on-content-click="false"
            :nudge-width="200"
            offset-x
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn v-bind="attrs" v-on="on" large text>
                    <v-avatar size="38px" item class="mr-2">
                        <v-img src="../assets/profile.png"></v-img>
                    </v-avatar>
                    {{$store.state.user.fname}}
                </v-btn>
            </template>

            <v-card>
                <v-list>
                        <v-list-item>
                                <v-list-item-avatar>
                                    <v-img
                                        src="../assets/profile.png"
                                    ></v-img>
                                </v-list-item-avatar>
                            <router-link to="/profile">
                                <v-list-item-content>
                                    <v-list-item-title>{{$store.state.user.fname}}</v-list-item-title>
                                    <v-list-item-subtitle>Admin</v-list-item-subtitle>
                                </v-list-item-content>
                            </router-link>
                        </v-list-item>
                </v-list>

                <v-divider></v-divider>

                <v-list>
                    <v-list-item>
                        <v-list-item-action>
                            <v-switch
                                @change="toggle"
                                v-model="hints"
                                color="black"
                            ></v-switch>
                        </v-list-item-action>
                        <v-list-item-title>Mode sombre</v-list-item-title>
                    </v-list-item>
                </v-list>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn text @click="menu = false">Fermer</v-btn>
                    <v-form method="POST" action="/logout">
                        <input type="hidden" name="_token" :value="csrf" />
                        <v-btn color="primary" @click="menu = !menu" type="submit" text>Se déconnecter </v-btn>
                    </v-form>
                </v-card-actions>
            </v-card>
        </v-menu>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data : () =>{
        return{
            fav: true,
            menu: false,
            message: false,
            hints: false,
            csrf : null
        }
    },
    methods : {
        toggle()
        {
            if(this.hints)
            {
                window.localStorage.setItem('darkMode',true)
                this.$vuetify.theme.dark = true
            }else{
               window.localStorage.removeItem('darkMode')
                this.$vuetify.theme.dark = false
            }
        }
    },
    created() {
        if(window.localStorage.getItem('darkMode') !== null)
        {
            this.hints = true
        }
        this.csrf = document.head.querySelector('meta[name="csrf-token"]').content
    }
}
</script>
