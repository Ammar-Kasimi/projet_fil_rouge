import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

export const useFridgeStore = defineStore('fridge', () => {

    const searchMode = ref('specific');
    const modes = [
        {
            id: 'specific',
            name: 'Specific Match',
            desc: 'Finds recipes that contain ALL of your selected ingredients together.'
        },
        {
            id: 'strict',
            name: 'Strict Pantry',
            desc: 'Finds recipes you can make using ONLY these ingredients.'
        }
    ];

    const selectedIngredients = ref([]);

    const categories = ref([]);

    const fetchCategories = async () => {
        try {
            const response = await axios.get('/api/ingredient_categories');
            categories.value = response.data.data;
        } catch (error) {
            console.error("Failed to fetch fridge categories", error);
        }
    };
    const toggleIngredient = (ingredientId) => {
        const index = selectedIngredients.value.indexOf(ingredientId);
        if (index > -1) {
            selectedIngredients.value.splice(index, 1);
        } else {
            selectedIngredients.value.push(ingredientId);
        }
    };

    const isSelected = (ingredientId) => {
        return selectedIngredients.value.includes(ingredientId);
    };

    const clearFridge = () => {
        selectedIngredients.value = [];
    };

    return { searchMode, modes, selectedIngredients, categories, toggleIngredient, isSelected, clearFridge,fetchCategories };
});