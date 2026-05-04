<template>
  <div class="max-w-5xl mx-auto p-6">
    
    <div class="mb-8 text-center">
      <h1 class="text-4xl font-bold text-gray-800">My Digital Fridge</h1>
      <p class="text-gray-500 mt-2">Select what you have, and we'll tell you what to cook.</p>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-sm border mb-6 flex justify-center gap-4">
      <label v-for="mode in fridgeStore.modes" :key="mode.id" class="flex items-center gap-2 cursor-pointer">
        <input 
          type="radio" 
          :value="mode.id" 
          v-model="fridgeStore.searchMode" 
          class="w-5 h-5 text-blue-600"
        />
        <span class="font-medium text-gray-700">{{ mode.name }}</span>
      </label>
    </div>

    <div class="mb-8">
      <div v-for="category in fridgeStore.categories" :key="category.id" class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-3 border-b pb-1">{{ category.name }}</h2>
        <div class="flex flex-wrap gap-3">
          <button 
            v-for="ing in category.ingredients" 
            :key="ing.id"
            @click="fridgeStore.toggleIngredient(ing.id)"
            :class="[
              'px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200',
              fridgeStore.isSelected(ing.id) 
                ? 'bg-blue-500 text-white shadow-md' 
                : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
            ]"
          >
            {{ ing.name }}
          </button>
        </div>
      </div>
    </div>

    <div class="text-center mb-12">
      <button 
        @click="recipeStore.getRecipes()"
        :disabled="fridgeStore.selectedIngredients.length === 0"
        class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg disabled:opacity-50"
      >
        Find Recipes
      </button>
      <button @click="fridgeStore.clearFridge()" class="ml-4 text-red-500 hover:underline text-sm font-medium">
        Clear Fridge
      </button>
    </div>

    <div v-if="recipeStore.recipes.length > 0">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">We found {{ recipeStore.recipes.length }} recipes!</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="recipe in recipeStore.recipes" :key="recipe.id" class="bg-white rounded-lg shadow-md overflow-hidden border p-5">
          <h3 class="text-lg font-bold text-gray-800">{{ recipe.name }}</h3>
          <div class="flex justify-between items-center mt-3 text-sm text-gray-500">
            <span>⏱ {{ recipe.prep_time }} mins</span>
            <span class="capitalize px-2 py-1 bg-gray-100 rounded">{{ recipe.difficulty }}</span>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useFridgeStore } from '../stores/fridge';
import { useRecipeStore } from '../stores/recipe';

const fridgeStore = useFridgeStore();
const recipeStore = useRecipeStore();
onMounted(() => {
  fridgeStore.fetchCategories();
});
</script>