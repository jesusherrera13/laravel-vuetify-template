<template>
    <v-app id="inspire">
      <v-navigation-drawer v-model="drawer">
        <Drawer />
      </v-navigation-drawer>
      <v-navigation-drawer
        location="right"
        v-model="drawer_right"
        temporary
      >
        <DrawerRight />
      </v-navigation-drawer>
      <v-app-bar density="compact">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-app-bar-title>{{ app_name }}</v-app-bar-title>
        <v-spacer></v-spacer>
        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn class="text-none" stacked>
          <v-badge content="2" color="error">
            <v-icon>mdi-bell-outline</v-icon>
          </v-badge>
        </v-btn>
        <v-btn class="text-none" 
          stacked
          @click="drawer_right = !drawer_right"
        >
          <v-badge content="9+" color="error">
            <v-icon>mdi-store-outline</v-icon>
          </v-badge>
        </v-btn>

        <v-menu
          transition="scale-transition"
        >
          <template v-slot:activator="{ props }">
            <v-btn
              icon
              color="primary"
              v-bind="props"
            >
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </template>

          <v-list density="compact">
            <v-list-item
              v-for="(item, i) in items"
              :key="i"
              :value="i"
              color="primary"
            >
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item title="Logout" value="logout" @click="logout"></v-list-item>
          </v-list>
        </v-menu>

        <!-- <v-btn icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn> -->
      </v-app-bar>
  
      <v-main>
        <router-view></router-view>
      </v-main>

    </v-app>
  </template>
  
  <script setup>
    import { ref, onMounted } from 'vue'
    import store from '../store'
    import Drawer from './Drawer.vue'
    import DrawerRight from './DrawerRight.vue'

    const drawer = ref(null)
    const drawer_right = ref(false)
    const app_name = ref(import.meta.env.VITE_APP_NAME)

    const items = ref([
      { title: 'Click Me' },
      { title: 'Click Me' },
      { title: 'Click Me' },
      { title: 'Click Me 2' },
    ])

    onMounted(() => {
      console.log(drawer.value)
      console.log(drawer.value)
    })

    const logout = () => {
      store.dispatch('logout');
    }
  </script>