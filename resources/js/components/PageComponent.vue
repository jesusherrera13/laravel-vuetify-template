<template>
    <v-container>
        <v-row>
            <v-col>
                <v-row>
                    <v-col
                    >
                        <div class="text-h6">{{ title }}</div>
                        
                    </v-col>
                    <v-col>
                        <slot name="breadcrumbs"></slot>
                    </v-col>
                </v-row>
                <slot name="header"></slot>
                <v-card>
                    <v-container>
                        <slot name="content"></slot>
                    </v-container>
                </v-card>
                <slot name="dialog"></slot>
            </v-col>
            <slot name="right_content"></slot>
        </v-row>
    </v-container>
</template>
<script setup>
const { title } = defineProps({
    title: String
});
</script>