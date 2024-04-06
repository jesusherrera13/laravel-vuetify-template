<template>
    <router-view></router-view>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  import store from '../store';
  
  const user = computed(() => store.state.user)
  </script>