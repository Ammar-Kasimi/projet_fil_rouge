import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';
 
export const useAdminStore = defineStore('admin', () => {
 
    const stats              = ref(null);
    const users              = ref([]);
    const pagination         = ref(null);
    const ingredients        = ref([]);
    const ingredientCategories = ref([]);
    const recipeCategories   = ref([]);
    const err_message        = ref(null);
    const loading            = ref(false);
 
    const fetchStats = async () => {
        try {
            const response = await axios.get('/api/admin/stats');
            stats.value = response.data.data;
        } catch (error) {
            console.error('Failed to fetch stats', error);
        }
    };
 
    const fetchUsers = async (page = 1) => {
        loading.value = true;
        try {
            const response = await axios.get(`/api/admin/users?page=${page}`);
            // Laravel paginate: response.data.data is the paginator object,
            // response.data.data.data is the actual array of users
            users.value      = response.data.data.data;
            pagination.value = response.data.data;
        } catch (error) {
            console.error('Failed to fetch users', error);
        } finally {
            loading.value = false;
        }
    };
 
    const banUser = async (userId) => {
        try {
            await axios.patch(`/api/admin/users/${userId}/ban`);
            const user = users.value.find(u => u.id === userId);
            if (user) user.isActive = false;
            return true;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to ban user.';
            return false;
        }
    };
 
    const unbanUser = async (userId) => {
        try {
            await axios.patch(`/api/admin/users/${userId}/unban`);
            const user = users.value.find(u => u.id === userId);
            if (user) user.isActive = true;
            return true;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to unban user.';
            return false;
        }
    };
 
    const fetchIngredients = async () => {
        try {
            const response = await axios.get('/api/ingredients');
            ingredients.value = response.data.data;
        } catch (error) {
            console.error('Failed to fetch ingredients', error);
        }
    };
 
    const createIngredient = async (formData) => {
        err_message.value = null;
        try {
            const response = await axios.post('/api/ingredients', formData);
            ingredients.value.push(response.data.data);
            return response.data;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to create ingredient.';
            return null;
        }
    };
 
    const updateIngredient = async (id, formData) => {
        err_message.value = null;
        try {
            const response = await axios.put(`/api/ingredients/${id}`, formData);
            const index = ingredients.value.findIndex(i => i.id === id);
            if (index !== -1) ingredients.value[index] = response.data.data;
            return response.data;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to update ingredient.';
            return null;
        }
    };
 
    const deleteIngredient = async (id) => {
        try {
            await axios.delete(`/api/ingredients/${id}`);
            ingredients.value = ingredients.value.filter(i => i.id !== id);
            return true;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to delete ingredient.';
            return false;
        }
    };
 
    const fetchIngredientCategories = async () => {
        try {
            const response = await axios.get('/api/ingredient_categories');
            ingredientCategories.value = response.data.data;
        } catch (error) {
            console.error('Failed to fetch ingredient categories', error);
        }
    };
 
    const createIngredientCategory = async (formData) => {
        err_message.value = null;
        try {
            const response = await axios.post('/api/ingredient_categories', formData);
            ingredientCategories.value.push(response.data.data);
            return response.data;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to create category.';
            return null;
        }
    };
 
    const updateIngredientCategory = async (id, formData) => {
        err_message.value = null;
        try {
            const response = await axios.put(`/api/ingredient_categories/${id}`, formData);
            const index = ingredientCategories.value.findIndex(c => c.id === id);
            if (index !== -1) ingredientCategories.value[index] = response.data.data;
            return response.data;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to update category.';
            return null;
        }
    };
 
    const deleteIngredientCategory = async (id) => {
        try {
            await axios.delete(`/api/ingredient_categories/${id}`);
            ingredientCategories.value = ingredientCategories.value.filter(c => c.id !== id);
            return true;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to delete category.';
            return false;
        }
    };
 
    const fetchRecipeCategories = async () => {
        try {
            const response = await axios.get('/api/recipe_categories');
            recipeCategories.value = response.data.data;
        } catch (error) {
            console.error('Failed to fetch recipe categories', error);
        }
    };
 
    const createRecipeCategory = async (formData) => {
        err_message.value = null;
        try {
            const response = await axios.post('/api/recipe_categories', formData);
            recipeCategories.value.push(response.data.data);
            return response.data;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to create category.';
            return null;
        }
    };
 
    const updateRecipeCategory = async (id, formData) => {
        err_message.value = null;
        try {
            const response = await axios.put(`/api/recipe_categories/${id}`, formData);
            const index = recipeCategories.value.findIndex(c => c.id === id);
            if (index !== -1) recipeCategories.value[index] = response.data.data;
            return response.data;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to update category.';
            return null;
        }
    };
 
    const deleteRecipeCategory = async (id) => {
        try {
            await axios.delete(`/api/recipe_categories/${id}`);
            recipeCategories.value = recipeCategories.value.filter(c => c.id !== id);
            return true;
        } catch (error) {
            err_message.value = error.response?.data?.message || 'Failed to delete category.';
            return false;
        }
    };
 
    return {
        stats, users, pagination, ingredients, ingredientCategories, recipeCategories,
        err_message, loading,
        fetchStats, fetchUsers, banUser, unbanUser,
        fetchIngredients, createIngredient, updateIngredient, deleteIngredient,
        fetchIngredientCategories, createIngredientCategory, updateIngredientCategory, deleteIngredientCategory,
        fetchRecipeCategories, createRecipeCategory, updateRecipeCategory, deleteRecipeCategory,
    };
});