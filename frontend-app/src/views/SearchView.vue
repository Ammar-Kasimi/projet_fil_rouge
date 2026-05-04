<template>
  <div class="min-h-screen bg-gray-50 text-gray-800 pb-20">

    <nav class="bg-white shadow-sm border-b-2 border-green-500 p-4 sticky top-0 z-10">
      <div class="max-w-6xl mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-black text-green-600">Social Recipe Hub</h1>
        <router-link to="/dashboard" class="text-gray-500 font-bold hover:text-green-600 cursor-pointer">
          Back to Dashboard
        </router-link>
      </div>
    </nav>

    <div class="max-w-4xl mx-auto mt-8 p-4">

      <div v-show="isFridgeOpen">
        <div class="text-center mb-10">
          <h2 class="text-4xl font-extrabold text-gray-800">What's in your fridge?</h2>
          <p class="text-gray-500 mt-2 text-lg">Select your ingredients and choose how you want to search.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 mb-8">
          <h3 class="text-lg font-bold mb-4 text-gray-700">Search Strategy</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-for="mode in fridgeStore.modes" :key="mode.id" @click="fridgeStore.searchMode = mode.id"
              :class="['p-4 rounded-xl border-2 cursor-pointer transition-all duration-200',
                fridgeStore.searchMode === mode.id ? 'border-green-500 bg-green-50 shadow-sm' : 'border-gray-100 hover:border-green-200']">
              <h4 class="font-bold text-gray-800" :class="{ 'text-green-700': fridgeStore.searchMode === mode.id }">{{ mode.name }}</h4>
              <p class="text-xs text-gray-500 mt-1">{{ mode.desc }}</p>
            </div>
          </div>
        </div>

        <div class="space-y-8">
          <div v-for="category in fridgeStore.categories" :key="category.id"
            class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">{{ category.name }}</h3>

            <div class="flex flex-wrap gap-3">
              <button v-for="ing in category.ingredients" :key="ing.id" @click="fridgeStore.toggleIngredient(ing.id)"
                :class="['px-4 py-2 rounded-full text-sm font-semibold border transition-all duration-200 cursor-pointer transform hover:-translate-y-0.5',
                  fridgeStore.isSelected(ing.id) ? 'bg-green-500 text-white border-green-600 shadow-md' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100']">
                {{ ing.name }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-show="!isFridgeOpen">
        
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 border-b-2 border-green-100 pb-4 gap-4">
          <h2 class="text-3xl font-extrabold text-gray-800">
            Found {{ recipeStore.recipes.length }} Recipes
          </h2>
          <button @click="isFridgeOpen = true" class="text-green-600 hover:text-green-800 font-bold flex items-center gap-2 px-4 py-2 bg-green-50 rounded-lg transition">
            ← Edit Ingredients
          </button>
        </div>

        <div v-if="recipeStore.recipes.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div v-for="recipe in recipeStore.recipes" :key="recipe.id" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
            <h3 class="text-xl font-bold text-gray-800">{{ recipe.name }}</h3>
            <div class="flex gap-4 mt-4 text-sm text-gray-600 font-medium border-t pt-4">
              <span>⏱ {{ recipe.prep_time }} mins</span>
              <span class="capitalize px-3 py-1 bg-gray-100 rounded-full">{{ recipe.difficulty }}</span>
            </div>
          </div>
        </div>

        <div v-else class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
          <div class="text-5xl mb-4">🍽️</div>
          <h3 class="text-2xl font-bold text-gray-700">No matching recipes</h3>
          <p class="text-gray-500 mt-2 max-w-md mx-auto">We couldn't find anything using just those ingredients. Try adding a few more or changing your search strategy!</p>
          <button @click="isFridgeOpen = true" class="mt-6 bg-green-500 text-white px-8 py-3 rounded-full font-bold hover:bg-green-600 shadow-md transition transform hover:-translate-y-1">
            Open Fridge
          </button>
        </div>

      </div>

    </div>

    <div v-if="fridgeStore.selectedIngredients.length > 0 && isFridgeOpen"
      class="fixed bottom-0 left-0 w-full bg-white border-t p-4 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)] flex justify-center z-20 transition-all">
      <div class="max-w-4xl w-full flex justify-between items-center">
        <button @click="fridgeStore.clearFridge" class="text-gray-400 hover:text-red-500 font-semibold cursor-pointer">
          Clear All
        </button>
        <button @click="executeSearch"
          class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transform hover:-translate-y-1 transition-all duration-200 cursor-pointer flex items-center gap-2">
          Find Recipes
          <span class="bg-white text-green-600 px-2 py-0.5 rounded-full text-xs">{{ fridgeStore.selectedIngredients.length }}</span>
        </button>
      </div>
    </div>

  </div>
</template>

<script setup>



import { ref,onMounted } from 'vue';
import { useFridgeStore } from '../stores/fridge';
import { useRouter } from 'vue-router';
import { useRecipeStore } from '../stores/recipe';
const fridgeStore = useFridgeStore();
const recipeStore = useRecipeStore();
const router = useRouter();

const isFridgeOpen = ref(true);

onMounted(() => {
  fridgeStore.fetchCategories();
});
// onMounted(() => {
//   fridgeStore.fetchCategories();
// });
const executeSearch = async () => {
  if (fridgeStore.selectedIngredients.length === 0) return;
  await recipeStore.getRecipes();
  // router.push({ name: 'catalog' });
  isFridgeOpen.value = false;
};
</script>