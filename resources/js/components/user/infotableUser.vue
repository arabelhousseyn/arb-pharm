<template>
    <v-container fluid>
        <v-simple-table>
            <template v-slot:default>
                <tbody>
                <tr>
                    <td>Nom commercial</td>
                    <td>{{ info.commercial_name }}</td>
                </tr>
                <tr>
                    <td>Nis</td>
                    <td>{{ info.nis }}</td>
                </tr>
                <tr>
                    <td>Nif</td>
                    <td>{{ info.nif }}</td>
                </tr>
                <tr>
                    <td>Numéro AR</td>
                    <td>{{ info.num_ar }}</td>
                </tr>
                <tr>
                    <td>Carte professionelle</td>
                    <td>{{ info.pro_card }}</td>
                </tr>
                <tr>
                    <td>Adresse</td>
                    <td>{{ info.adress }}</td>
                </tr>
                <tr>
                    <td>Code d'activité</td>
                    <td>{{ code }}</td>
                </tr>
                <tr>
                    <td>Numéro de RC</td>
                    <td>{{ info.num_rc }}</td>
                </tr>
                </tbody>
            </template>
        </v-simple-table>
    </v-container>
</template>

<script>
export default {
    props : ['info','code'],
    data () {
        return {
            desserts: [
                {
                    name: 'Frozen Yogurt',
                    calories: 159,
                },
                {
                    name: 'Ice cream sandwich',
                    calories: 237,
                },
                {
                    name: 'Eclair',
                    calories: 262,
                },
                {
                    name: 'Cupcake',
                    calories: 305,
                },
                {
                    name: 'Gingerbread',
                    calories: 356,
                },
                {
                    name: 'Jelly bean',
                    calories: 375,
                },
                {
                    name: 'Lollipop',
                    calories: 392,
                },
                {
                    name: 'Honeycomb',
                    calories: 408,
                },
                {
                    name: 'Donut',
                    calories: 452,
                },
                {
                    name: 'KitKat',
                    calories: 518,
                },
            ],
        }
    },
}
</script>
