
import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';
import { useFridgeStore } from './fridge';

export const useRecipeStore = defineStore('recipe', () => {

    const recipes = ref([]);
    const catalog = ref([]);
    const err_message = ref(null);

    const recipeCategories = ref([]);
    const currentRecipe = ref(null);

    const getRecipes = async () => {
        const fridgeStore = useFridgeStore();


        try {
            const response = await axios.post('/api/recipes/search', {
                ingredients: fridgeStore.selectedIngredients,
                mode: fridgeStore.searchMode
            });
            recipes.value = response.data.data;
        } catch (error) {
            console.error("Search API failed", error);
        }
    };

    const fetchRecipe = async (id) => {
        try {
            const response = await axios.get(`/api/recipes/${id}`);
            currentRecipe.value = response.data.data;
        } catch (error) {
            console.error("Failed to fetch recipe details", error);
            currentRecipe.value = null;
        }
    };


    const fetchRecipeCategories = async () => {
        try {
            const response = await axios.get('/api/recipe_categories');
            recipeCategories.value = response.data.data;
        } catch (error) {
            console.error("Failed to fetch recipe categories", error);

        }
    };
    const fetchCatalog = async () => {
        try {
            const response = await axios.get('/api/my-recipes');
            catalog.value = response.data.data;
        } catch (error) {
            console.error("Failed to fetch catalog", error);
        }
    };

    const createRecipe = async (recipeData) => {
        err_message.value = null;
        try {
            const response = await axios.post('/api/recipes', recipeData);
            catalog.value.push(response.data.data);
            return response.data;
        } catch (error) {
            err_message.value = error.response?.data?.message || "Failed to create recipe.";
            return null;
        }
    };

    const deleteRecipe = async (id) => {
        try {
            await axios.delete(`/api/recipes/${id}`);
            catalog.value = catalog.value.filter(r => r.id !== id);
            return true;
        } catch (error) {
            console.error("Failed to delete recipe", error);
            return false;
        }

    };
    
    const updateRecipe = async (id, recipeData) => {
        err_message.value = null;
        try {
            const response = await axios.put(`/api/recipes/${id}`, recipeData);

            const index = catalog.value.findIndex(r => r.id == id);
            if (index !== -1) {
                catalog.value[index] = response.data.data;
            }

            return response.data;
        } catch (error) {
            err_message.value = error.response?.data?.message || "Failed to update recipe.";
            return null;
        }
    };

    return { updateRecipe, deleteRecipe, currentRecipe, fetchRecipe, recipes, catalog, err_message, getRecipes, fetchCatalog, createRecipe, fetchRecipeCategories, recipeCategories };
});