<!-- <script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
const router = useRouter();

const form = ref({
    email: '',
    password: ''
});
const errorDetails = ref('');
 const login=async ()=>{
    errorDetails.value = '';
    try{ 
        // await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/api/login', form.value);
        router.push({ name: 'dashboard' });
    }
    catch(error){
        errorDetails.value='password or email is incorrect,please try again'
    }
 }
</script>
<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Sign In</h2>
            
            <p v-if="errorDetails" class="text-red-500 text-sm mb-4 text-center">
                {{ errorDetails }}
            </p>

            <form @submit.prevent="login" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" v-model="form.email" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" v-model="form.password" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Secure Login
                </button>
            </form>
        </div>
    </div>
</template> -->
<!-- 

<template>
    <div class="min-h-screen bg-green-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96 border-t-4 border-green-500">
            <h2 class="text-2xl font-bold text-green-700 mb-6 text-center">Welcome Back</h2>
            
            <form @submit.prevent="handleLogin">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Email</label>
                    <input v-model="form.email" type="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Password</label>
                    <input v-model="form.password" type="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500">
                </div>

                <button type="submit" 
                        class="w-full bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 transition duration-200">
                    Log In
                </button>
            </form>
            
            <p class="text-center mt-4 text-sm text-gray-600">
                Don't have an account? 
                <router-link to="/register" class="text-green-600 hover:underline">Register</router-link>
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


const form = ref({
    email: '',
    password: ''
});

const handleLogin = async () => {
    try {
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/api/login', form.value);
        await authStore.checkAuth();
        
        router.push({ name: 'dashboard' });
    } catch (error) {
        alert("Login failed. Please check your email and password.");
    }
};
</script> -->

<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-gray-100 flex items-center justify-center p-4">
        
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border-t-8 border-green-500">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-800">Welcome Back</h2>
                <p class="text-gray-500 mt-2">Log in to your kitchen dashboard.</p>
            </div>

            <div v-if="errorMessage" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm text-center">
                {{ errorMessage }}
            </div>
            
            <form @submit.prevent="handleLogin" class="space-y-5">
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

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                    Log In
                </button>
            </form>
            
            <p class="text-center mt-6 text-sm text-gray-600">
                Don't have an account? 
                <router-link to="/register" class="text-green-600 font-semibold hover:text-green-700 hover:underline cursor-pointer">Create one here</router-link>
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
    email: '',
    password: ''
});

const handleLogin = async () => {
    try {
        errorMessage.value = '';
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/api/login', form.value);
        
        await authStore.checkAuth();
        router.push({ name: 'dashboard' });
    } catch (error) {
        errorMessage.value = "Invalid email or password.";
    }
};
</script>