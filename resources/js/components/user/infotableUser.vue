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
                    <td>Nom sociale</td>
                    <td>{{ info.social_name }}</td>
                </tr>
                <tr>
                    <td>Siege social</td>
                    <td>{{ info.social_place }}</td>
                </tr>
                <tr>
                    <td>Code d'activité</td>
                    <td>{{ info.activity_code }}</td>
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
    props : ['info'],
}
</script>
