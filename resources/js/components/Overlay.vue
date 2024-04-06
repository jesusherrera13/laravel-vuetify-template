<template>
    <v-overlay v-model="overlay"
        class="align-center justify-center"
    >
        <v-progress-circular
        color="amber"
        indeterminate
        ></v-progress-circular>
    </v-overlay>
</template>

<script>
export default {
    data: () => ({
        overlay: true
    })
}
</script>
