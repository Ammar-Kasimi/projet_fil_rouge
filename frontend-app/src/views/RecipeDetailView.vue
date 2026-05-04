<template>
  <div v-if="isLoading" class="flex justify-center items-center min-h-screen bg-gray-50">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-orange-500"></div>
  </div>

  <div v-else-if="recipe" class="max-w-5xl mx-auto p-6 mt-8">
    
    <button @click="handleBack" class="mb-6 flex items-center gap-2 text-gray-500 hover:text-orange-600 font-bold transition duration-200">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
      go back
    </button>

    <div class="bg-white rounded-[2rem] shadow-xl shadow-orange-100/50 border border-orange-100 overflow-hidden mb-8">
      
      <div class="p-8 md:p-12 bg-gradient-to-br from-orange-50 to-white border-b border-orange-100">
        <div class="flex flex-wrap justify-between items-start gap-6">
          <div>
            <span v-if="recipe.recipe_category || recipe.recipeCategory" class="inline-block bg-orange-500 text-white px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm shadow-orange-200 mb-3">
              {{ recipe.recipe_category?.name || recipe.recipeCategory?.name }}
            </span>
            <h1 class="text-4xl md:text-6xl font-black text-gray-900 leading-tight">{{ recipe.name }}</h1>
            <div class="flex gap-3 mt-4 md:mt-0">
  <button @click="goToEdit" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-xl font-bold border border-blue-100 transition-colors shadow-sm">
    ✏️ Edit
  </button>
  
  <button @click="handleDelete" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2 rounded-xl font-bold border border-red-100 transition-colors shadow-sm">
    🗑️ Delete
  </button>
</div>
          </div>
          
          <div class="flex gap-4">
             <div class="flex flex-col justify-center items-center bg-white px-6 py-4 rounded-2xl shadow-sm border border-orange-100 min-w-[100px]">
               <span class="block text-3xl font-black text-orange-500">{{ recipe.prep_time }}</span>
               <span class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Mins</span>
             </div>
             <div class="flex flex-col justify-center items-center bg-white px-6 py-4 rounded-2xl shadow-sm border border-orange-100 min-w-[100px]">
               <span class="block text-2xl font-black text-blue-500 capitalize">{{ recipe.difficulty }}</span>
               <span class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Level</span>
             </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 border-b border-gray-100 bg-white">
        <div class="p-6 text-center border-r border-b md:border-b-0 border-gray-100 hover:bg-gray-50 transition">
          <span class="text-gray-400 text-xs font-black block uppercase tracking-widest mb-1">Calories</span>
          <span class="text-3xl font-black text-gray-800">{{ Math.round(recipe.calories || 0) }} <span class="text-lg text-gray-400">kcal</span></span>
        </div>
        <div class="p-6 text-center border-b md:border-b-0 md:border-r border-gray-100 hover:bg-gray-50 transition">
          <span class="text-gray-400 text-xs font-black block uppercase tracking-widest mb-1">Protein</span>
          <span class="text-3xl font-black text-blue-600">{{ Math.round(recipe.protein || 0) }} <span class="text-lg text-blue-300">g</span></span>
        </div>
        <div class="p-6 text-center border-r border-gray-100 hover:bg-gray-50 transition">
          <span class="text-gray-400 text-xs font-black block uppercase tracking-widest mb-1">Carbs</span>
          <span class="text-3xl font-black text-green-600">{{ Math.round(recipe.carbs || 0) }} <span class="text-lg text-green-300">g</span></span>
        </div>
        <div class="p-6 text-center hover:bg-gray-50 transition">
          <span class="text-gray-400 text-xs font-black block uppercase tracking-widest mb-1">Fat</span>
          <span class="text-3xl font-black text-red-500">{{ Math.round(recipe.total_fat || 0) }} <span class="text-lg text-red-300">g</span></span>
        </div>
      </div>

      <div class="p-8 md:p-12 grid grid-cols-1 lg:grid-cols-5 gap-12 bg-white">
        
        <div class="lg:col-span-2">
          <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-green-100 text-green-600 p-2 rounded-xl">🥗</span> Ingredients
          </h3>
          <ul class="space-y-4">
            <li v-for="ing in recipe.ingredients" :key="ing.id" class="flex justify-between items-center p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-green-300 transition-colors">
              <span class="font-bold text-gray-800 text-lg">{{ ing.name }}</span>
              <span class="text-green-700 font-black bg-green-100 px-4 py-1.5 rounded-lg border border-green-200 shadow-sm">
                {{ ing.pivot.amount }} {{ ing.pivot.unit }}
              </span>
            </li>
          </ul>
        </div>

        <div class="lg:col-span-3">
          <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-blue-100 text-blue-600 p-2 rounded-xl">👨‍🍳</span> Preparation
          </h3>
          
          <div v-if="recipe.instructions && recipe.instructions.length > 0" class="space-y-6">
            <div v-for="(step, index) in recipe.instructions" :key="index" class="flex gap-5 bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
              <div class="flex-none w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center font-black text-xl border border-blue-100">
                {{ index + 1 }}
              </div>
              <p class="text-gray-700 leading-relaxed text-lg pt-1">{{ step.desc }}</p>
            </div>
          </div>
          
          <div v-else class="bg-orange-50 p-8 rounded-3xl border-2 border-dashed border-orange-200 flex flex-col items-center justify-center text-center">
            <span class="text-4xl mb-4">⚡</span>
            <h4 class="text-xl font-black text-orange-800 mb-2">Quick Mix Recipe!</h4>
            <p class="text-orange-600 font-medium">
              No complex steps needed. Just combine your ingredients in the quantities listed and enjoy!
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRecipeStore } from '../stores/recipe';
import { useRoute, useRouter } from 'vue-router';

const recipeStore = useRecipeStore();
const route = useRoute();
const router = useRouter(); 

const isLoading = ref(true);
const recipe = computed(() => recipeStore.currentRecipe);

onMounted(async () => {
  try {
    await recipeStore.fetchRecipe(route.params.id);
  } finally {
    isLoading.value = false;
  }
});
const handleBack = () => {
  if (window.history.state.back === '/create-recipe') {
    router.push({ name: 'catalog' }); 
  } else {
    router.back(); 
  }
};
const handleDelete = async () => {
    if (confirm("Delete this recipe?")) {
        const success = await recipeStore.deleteRecipe(recipe.value.id);
        if (success) router.push({ name: 'catalog' });
    }
};
const goToEdit = () => {
    router.push({ name: 'editRecipe', params: { id: recipe.value.id } });
};
</script>