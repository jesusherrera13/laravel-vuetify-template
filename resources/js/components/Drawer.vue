<template>
    <v-card
      class="mx-auto"
      max-width="300"
      height="100vh"
    >
    <v-list density="compact" nav :lines="false">
        <template v-for="modulo in user.modules" :key="modulo.key">
          <v-list-subheader v-text="modulo.name"></v-list-subheader>
          <v-list-item
            v-for="(item, i) in modulo.menus"
            :key="i"
            :value="item"
            color="primary"
            :to="item.route"
          >
            <template v-slot:prepend>
              <v-icon :icon="item.icon"></v-icon>
            </template>
    
            <v-list-item-title v-text="item.name"></v-list-item-title>
          </v-list-item>
        </template>
      </v-list>


      <!-- <v-list density="compact" nav :lines="false">
        <template v-for="modulo in modulos" :key="modulo">
          <v-list-subheader v-text="modulo.text"></v-list-subheader>
          <v-list-item
            v-for="(item, i) in modulo.opciones"
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
        </template>
      </v-list> -->
    </v-card>
  </template>
  <script>
    import store from '../store';
    import { computed } from 'vue';
    export default {
      data: () => ({
        user: computed(() => store.state.user.data),
        modulos: [
          { 
            text: 'Sistema', 
            icon: 'mdi-clock',
            opciones: [
              { text: 'Users', icon: 'mdi-account', route:'/users'},
              { text: 'Settings', icon: 'mdi-cog-outline', route:'/settings'},
              { text: 'Conversions', icon: 'mdi-flag' },
            ] 
          },
          { 
            text: 'Audiencie', 
            icon: 'mdi-account',
            opciones: [
            { text: 'My Files', icon: 'mdi-folder' },
            { text: 'Shared with me', icon: 'mdi-account-multiple' },
            { text: 'Starred', icon: 'mdi-star' },
            { text: 'Recent', icon: 'mdi-history' },
            { text: 'Offline', icon: 'mdi-check-circle' },
            { text: 'Uploads', icon: 'mdi-upload' },
            { text: 'Backups', icon: 'mdi-cloud-upload' },
            ] 
          },
        ],
      }),
      created() {
        store.dispatch('systemModules', this.user);
      }
    }
  </script>