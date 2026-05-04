import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);
    const checkAuth = async () => {
        try {
            const response = await axios.get('/api/user');
            user.value = response.data;
        } catch (error) {
            user.value = null;
        }
    };
    const logout = async () => {
        await axios.post('/api/logout');
        user.value = null;
    };

    return { user, checkAuth, logout };
});