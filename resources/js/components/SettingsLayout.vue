<template>
    <PageComponent title="Settings">
        <template v-slot:content>
            <v-row>
                <v-col cols="2">
                    <v-list
                        :lines="false"
                        density="compact"
                        nav
                    >
                        <v-list-item
                            v-for="(item, i) in items"
                            :key="i"
                            :value="item"
                            color="primary"
                            :to="item.route"
                        >
                            <template v-slot:prepend>
                                <v-icon :icon="item.icon"></v-icon>
                            </template>
                            
                            <v-list-item-title v-text="item.text"></v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col>
                    <router-view></router-view>
                </v-col>
            </v-row>
        </template>
    </PageComponent>
</template>
<script>

import PageComponent from './PageComponent.vue'

export default {
    data() {
        return {
            items: [
                { text: 'Roles', icon: 'mdi-account-cog', route:'/roles'},
                { text: 'Starred', icon: 'mdi-star' },
                { text: 'Recent', icon: 'mdi-history' },
                { text: 'Offline', icon: 'mdi-check-circle' },
                { text: 'Uploads', icon: 'mdi-upload' },
                { text: 'Backups', icon: 'mdi-cloud-upload' },
            ]
        }
    },
    components: {
        PageComponent
    }
}
</script>