<template>
    <v-snackbar
        v-model="snackbar"
        :timeout="timeout"
        color="green"
    >
        {{ text }}
    </v-snackbar>
</template>

<script>
export default {
    props : ['snackbar'],
    data: () => ({
        text: 'Information traitée avec succès',
        timeout: 3000,
    }),
}
</script>
