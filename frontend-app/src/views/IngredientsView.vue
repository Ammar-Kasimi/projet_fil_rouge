<template>
  <div class="p-8 max-w-5xl mx-auto bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Database Ingredients</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div 
        v-for="ing in store.ingredients" 
        :key="ing.id" 
        class="p-4 bg-white rounded-lg shadow border border-gray-100 flex flex-col items-center"
      >
        <span class="text-lg font-semibold text-gray-700">{{ ing.name }}</span>
        
        <span v-if="ing.ingredient_category" class="text-xs text-blue-500 mt-1 uppercase tracking-wide">
          {{ ing.ingredient_category.name }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useIngredientStore } from '../stores/ingredientStore'

const store = useIngredientStore()

onMounted(() => {
  store.fetchIngredients()
})
</script>