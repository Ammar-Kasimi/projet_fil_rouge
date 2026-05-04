<template>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-sm border border-gray-100 mt-10">
        <h1 class="text-3xl font-black mb-6 text-gray-800">Create a New Recipe</h1>

        <form @submit.prevent="submitUpdate" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700">Recipe Name</label>
                    <input v-model="form.name" type="text" required
                        class="mt-1 w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
                        placeholder="E.g., Garlic Butter Chicken">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">Category</label>
                    <select v-model="form.recipe_category_id" required
                        class="mt-1 w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white">
                        <option :value="null" disabled>Select a Category</option>
                        <option v-for="cat in recipeStore.recipeCategories" :key="cat.id" :value="cat.id">
                            {{ cat.name }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">Prep Time (mins)</label>
                    <input v-model="form.prep_time" type="number" required
                        class="mt-1 w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
                        min="1">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">Difficulty</label>
                    <select v-model="form.difficulty"
                        class="mt-1 w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white">
                        <option value="beginner">Beginner</option>
                        <option value="medium">Medium</option>
                        <option value="advanced">Advanced</option>
                        <option value="chef">Chef</option>
                    </select>
                </div>
            </div>

            <div class="border-t pt-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Ingredients</h2>
                    <button type="button" @click="addIngredient"
                        class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-100 transition">
                        + Add Ingredient
                    </button>
                </div>

                <div v-for="(ing, index) in form.ingredients" :key="index"
                    class="flex gap-3 mb-3 items-center bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <select v-model="ing.id" required class="flex-1 p-2 border rounded-lg bg-white outline-none">
                        <option :value="null" disabled>Select Ingredient</option>
                        <optgroup v-for="cat in fridgeStore.categories" :key="cat.id" :label="cat.name">
                            <option v-for="item in cat.ingredients" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </optgroup>
                    </select>

                    <input v-model="ing.amount" type="number" placeholder="Amt"
                        class="w-24 p-2 border rounded-lg outline-none" required min="0.1" step="0.1">

                    <select v-model="ing.unit" class="w-24 p-2 border rounded-lg bg-white outline-none">
                        <option value="g">g</option>
                        <option value="kg">kg</option>
                        <option value="ml">ml</option>
                        <option value="l">L</option>
                        <option value="piece">piece</option>
                    </select>

                    <button type="button" @click="removeIngredient(index)"
                        class="text-red-400 font-bold hover:text-red-600 px-2 text-xl">&times;</button>
                </div>
            </div>

            <div class="border-t pt-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Instructions (Optional)</h2>
                    <button type="button" @click="addInstruction"
                        class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-100 transition">
                        + Add Step
                    </button>
                </div>

                <div v-for="(step, index) in form.instructions" :key="index" class="flex gap-3 mb-3 items-start">
                    <span class="mt-2 font-black text-gray-300">{{ index + 1 }}</span>
                    <textarea v-model="step.desc" rows="1" placeholder="Describe this step..."
                        class="flex-1 p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    <button type="button" @click="removeInstruction(index)"
                        class="text-red-400 font-bold hover:text-red-600 px-2 text-xl">&times;</button>
                </div>
            </div>

            <div class="border-t pt-6">
                <p v-if="recipeStore.err_message" class="text-red-500 mb-4 font-medium">{{ recipeStore.err_message }}
                </p>
                <button type="submit"
                    class="w-full bg-green-600 text-white font-black py-4 rounded-xl hover:bg-green-700 shadow-lg shadow-green-100 transition-all transform hover:-translate-y-0.5">
                    Save Recipe
                </button>
            </div>

        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRecipeStore } from '../stores/recipe';
import { useFridgeStore } from '../stores/fridge';
import { useRouter ,useRoute} from 'vue-router';


const recipeStore = useRecipeStore();
const fridgeStore = useFridgeStore();
const router = useRouter();
const route = useRoute();  

const form = ref({
    name: '',
    prep_time: 15,
    difficulty: 'beginner',
    recipe_category_id: null,
    ingredients: [{ id: null, amount: null, unit: 'g' }],
    instructions: [{ desc: '' }]
});

onMounted(async () => {
    recipeStore.fetchRecipeCategories();

    if (fridgeStore.categories.length === 0) {
        fridgeStore.fetchCategories();
    }
    await recipeStore.fetchRecipe(route.params.id);

    const data = recipeStore.currentRecipe;
    form.value = {
        name: data.name,
        prep_time: data.prep_time,
        difficulty: data.difficulty,
        recipe_category_id: data.recipe_category_id,
        ingredients: data.ingredients.map(ing => ({
            id: ing.id,
            amount: ing.pivot.amount,
            unit: ing.pivot.unit
        })),
        instructions: data.instructions || [{ desc: '' }]
    };
});


const addIngredient = () => form.value.ingredients.push({ id: null, amount: null, unit: 'g' });
const removeIngredient = (index) => form.value.ingredients.length > 1 && form.value.ingredients.splice(index, 1);

const addInstruction = () => form.value.instructions.push({ desc: '' });
const removeInstruction = (index) => {
    form.value.instructions.splice(index, 1);
};
const submitUpdate = async () => {
    const payload = JSON.parse(JSON.stringify(form.value));

    if (payload.instructions) {
        payload.instructions = payload.instructions.filter(step => step.desc && step.desc.trim() !== '');
        if (payload.instructions.length === 0) {
        payload.instructions = null;
    }
    }
    

    const result = await recipeStore.updateRecipe(route.params.id, payload);
  
    if (result && (result.status === 'success' || result.data?.status === 'success')) {
        alert("Recipe Updated Successfully!");
        router.push({ name: 'recipeDetail', params: { id: route.params.id } });
    }
};
const submitRecipe = async () => {
    const payload = JSON.parse(JSON.stringify(form.value));

    if (payload.instructions) {
        payload.instructions = payload.instructions.filter(step => step.desc.trim() !== '');
    }
    if (payload.instructions.length === 0) {
        payload.instructions = null;
    }
    const result = await recipeStore.createRecipe(payload);
    console.log("Full Result from Store:", result);
    const isSuccess = result && (result.status === 'success' || result.data?.status === 'success');

    if (isSuccess) {
        const recipeId = result.data?.id || result.id;

        alert("Recipe Created Successfully!");

        router.push({ name: 'recipeDetail', params: { id: recipeId } });
    } else {
        console.error("Redirect failed: The success condition was not met.");
    }
    if (result && result.status === 'success') {
        alert("Recipe Created Successfully!");
        router.push({ name: 'recipeDetail', params: { id: result.data.id } });
    }

};

</script>