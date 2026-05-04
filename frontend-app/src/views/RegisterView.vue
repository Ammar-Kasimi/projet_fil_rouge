
<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-gray-100 flex items-center justify-center p-4">
        
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border-t-8 border-green-500">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-800">Join the Kitchen</h2>
                <p class="text-gray-500 mt-2">Create an account to start tracking your meals.</p>
            </div>

            <div v-if="errorMessage" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                {{ errorMessage }}
            </div>
            
            <form @submit.prevent="handleRegister" class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Username</label>
                    <input v-model="form.username" type="text" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition-colors">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input v-model="form.email" type="email" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition-colors">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Password</label>
                    <input v-model="form.password" type="password" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition-colors">
                </div>

                <!-- <div>
                    <label class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
                    <input v-model="form.password_confirmation" type="password" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition-colors">
                </div> -->

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                    Create Account
                </button>
            </form>
            
            <p class="text-center mt-6 text-sm text-gray-600">
                Already have an account? 
                <router-link to="/login" class="text-green-600 font-semibold hover:text-green-700 hover:underline cursor-pointer">Log in here</router-link>
            </p>
        </div>
    </div>
</template>

<script setup>  
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const errorMessage = ref(''); 

const form = ref({
    username: '',
    email: '',
    password: '',
    password_confirmation: '' 
});

const handleRegister = async () => {
    try {
        errorMessage.value = '';
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/api/register', form.value); 
        
        await authStore.checkAuth();
        router.push({ name: 'dashboard' });
    } catch (error) {
       
        if (error.response && error.response.status === 422) {
           
            errorMessage.value = Object.values(error.response.data.errors)[0][0];
        } else {
            errorMessage.value = "Registration failed. Check console for details.";
            console.error(error);
        }
    }
};
</script>