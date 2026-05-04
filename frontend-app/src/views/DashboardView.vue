<template>
    <div class="min-h-screen bg-gray-50">
        
        <nav class="bg-white shadow-md border-b-4 border-green-500">
            <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
                <h1 class="text-2xl font-extrabold text-green-600 tracking-tight">FitKitchen</h1>
                
                <div class="flex items-center gap-6">
                    <router-link 
                        v-if="authStore.user?.role?.name === 'admin'" 
                        to="/admin"
                        class="bg-green-100 text-green-700 hover:bg-green-200 px-4 py-2 rounded-lg font-bold transition-colors text-sm border border-green-200">
                        🛡️ Admin Panel
                    </router-link>

                    <button @click="handleLogout" 
                            class="text-gray-600 hover:text-red-500 font-semibold transition-colors duration-200 cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Log Out
                    </button>
                </div>
            </div>
        </nav>

        <div class="p-8 max-w-6xl mx-auto mt-4">
            
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h2 v-if="authStore.user" class="text-4xl font-extrabold text-gray-800 mb-2">
                    Welcome to your kitchen, <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-green-700">{{ authStore.user.username }}</span>!
                </h2>
                <h2 v-else class="text-4xl font-extrabold text-gray-400 mb-2">
                    Loading your kitchen...
                </h2>
                
                <p class="text-gray-500 text-lg">
                    What would you like to cook today? 
                </p>
                
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <router-link to="/search" class="block bg-green-50 border border-green-100 p-6 rounded-xl cursor-pointer hover:shadow-md hover:bg-green-100 transition-all">
                        <h3 class="font-bold text-green-800 text-xl">Search Fridge</h3>
                        <p class="text-green-600 text-sm mt-1">Find recipes based on what you have.</p>
                    </router-link>

                    <router-link to="/catalog" class="block bg-blue-50 border border-blue-100 p-6 rounded-xl cursor-pointer hover:shadow-md hover:bg-blue-100 transition-all">
                        <h3 class="font-bold text-blue-800 text-xl">My Recipes</h3>
                        <p class="text-blue-600 text-sm mt-1">Manage the recipes you've created.</p>
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const handleLogout = async () => {
    await authStore.logout();
    router.push({ name: 'login' });
};
</script>