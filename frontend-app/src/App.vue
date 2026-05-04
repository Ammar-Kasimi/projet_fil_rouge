<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from './stores/auth';

const authStore = useAuthStore();

onMounted(async () => {
  await authStore.checkAuth();
});
</script>

<template>
  <div style="font-family: sans-serif; background-color: #f4f4f4; min-height: 100vh; padding: 20px;">
    
    <router-view></router-view>

  </div>
</template>