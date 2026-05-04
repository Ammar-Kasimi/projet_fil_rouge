<template>
  <div class="max-w-6xl mx-auto p-6 mt-8">
    
    <div class="mb-4">
      <router-link to="/dashboard" class="inline-flex items-center gap-2 text-gray-500 hover:text-green-600 font-bold transition-colors">
        <span class="text-xl">←</span> Back to Dashboard
      </router-link>
    </div>

    <div class="flex justify-between items-center mb-8">
      <h1 class="text-4xl font-black text-gray-900">My Recipes</h1>
      <router-link to="/create-recipe" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-orange-200 transition">
        + New Recipe
      </router-link>
    </div>

    <div v-if="recipeStore.catalog.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="recipe in recipeStore.catalog" :key="recipe.id" class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300">
        
        <div class="p-6">
          <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-3">
            {{ recipe.recipe_category?.name }}
          </span>
          <h2 class="text-2xl font-black text-gray-800 mb-2 truncate">{{ recipe.name }}</h2>
          
          <div class="flex gap-4 text-sm text-gray-500 font-bold mt-4">
            <span class="flex items-center gap-1">⏱️ {{ recipe.prep_time }}m</span>
            <span class="flex items-center gap-1 capitalize">🔥 {{ recipe.difficulty }}</span>
          </div>

          <div class="mt-6 border-t border-gray-50 pt-4 flex justify-between items-center">
            <span class="text-gray-400 text-sm font-bold">{{ Math.round(recipe.calories) }} kcal</span>
            <router-link :to="{ name: 'recipeDetail', params: { id: recipe.id } }" class="text-blue-600 font-black hover:text-blue-800 flex items-center gap-1">
              View <span class="text-xl">→</span>
            </router-link>
          </div>
        </div>

      </div>
    </div>

    <div v-else class="text-center py-20 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 mt-10">
      <span class="text-6xl block mb-4">👨‍🍳</span>
      <h3 class="text-2xl font-black text-gray-800 mb-2">Your kitchen is empty</h3>
      <p class="text-gray-500 mb-6">You haven't created any recipes yet.</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useRecipeStore } from '../stores/recipe';

const recipeStore = useRecipeStore();

onMounted(() => {
  recipeStore.fetchCatalog();
});
</script>