<template>
    <div>
        <v-container fluid>
            <bread-crumbs />
            <div style="margin-top: 35px;">
                    <general />
            </div>

        </v-container>
    </div>
</template>

<script>
import breadCrumbs from '../components/breadcrumbs/breadcrumbs.vue'
import General from "../components/general/general";
export default {
    data : () => {
        return{
            tab: null,
        }
    },
    components : {
        General,
        breadCrumbs,
    }
}
</script>

