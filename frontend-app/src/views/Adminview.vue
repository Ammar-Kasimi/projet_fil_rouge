<template>
  <div class="min-h-screen bg-gray-50">
 
  
    <div class="bg-white border-b border-gray-200 shadow-sm">
      <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
          <span class="text-2xl">🛡️</span>
          <div>
            <h1 class="text-2xl font-black text-gray-900">Admin Panel</h1>
            <p class="text-xs text-gray-400 font-medium">Social Recipe Hub</p>
          </div>
        </div>
        <button @click="router.push({ name: 'dashboard' })"
          class="text-sm text-gray-500 hover:text-gray-800 font-bold transition-colors">
          ← Back to Dashboard
        </button>
      </div>
    </div>
 
    <div class="max-w-7xl mx-auto px-6 py-8">
 
      
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
        <div v-for="card in statCards" :key="card.label"
          class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
          <span class="text-3xl block mb-2">{{ card.icon }}</span>
          <div class="text-3xl font-black text-gray-800">
            {{ adminStore.stats ? adminStore.stats[card.key] : '…' }}
          </div>
          <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">{{ card.label }}</div>
        </div>
      </div>
 
  
      <div class="flex flex-wrap gap-2 mb-6 bg-white p-1.5 rounded-xl border border-gray-200 shadow-sm w-fit">
        <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id"
          :class="[
            'px-5 py-2.5 rounded-lg font-bold text-sm transition-all',
            activeTab === tab.id ? 'bg-green-500 text-white shadow-sm' : 'text-gray-500 hover:text-gray-800'
          ]">
          {{ tab.icon }} {{ tab.label }}
        </button>
      </div>
 
    
      <p v-if="adminStore.err_message" class="text-red-500 text-sm font-medium mb-4">
        ⚠️ {{ adminStore.err_message }}
      </p>
 
   
      <div v-if="activeTab === 'users'">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-black text-gray-800">User Management</h2>
            <span class="text-sm text-gray-400">{{ adminStore.pagination?.total ?? '…' }} total users</span>
          </div>
 
          <div v-if="adminStore.loading" class="flex justify-center py-20">
            <div class="animate-spin rounded-full h-10 w-10 border-t-4 border-green-500"></div>
          </div>
 
          <table v-else class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
              <tr>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">User</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Email</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Role</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Recipes</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Status</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="user in adminStore.users" :key="user.id"
                class="hover:bg-gray-50 transition-colors"
                :class="{ 'opacity-50': !user.isActive }">
                <td class="px-6 py-4">
                  <div class="font-bold text-gray-800">{{ user.username }}</div>
                  <div class="text-xs text-gray-400">ID #{{ user.id }}</div>
                </td>
                <td class="px-6 py-4 text-gray-500">{{ user.email }}</td>
                <td class="px-6 py-4">
                  <span class="px-2 py-1 rounded-full text-xs font-black"
                    :class="user.role?.name === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600'">
                    {{ user.role?.name ?? 'user' }}
                  </span>
                </td>
                <td class="px-6 py-4 font-bold text-gray-700">{{ user.recipes_count }}</td>
                <td class="px-6 py-4">
                  <span :class="user.isActive ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                    class="px-2 py-1 rounded-full text-xs font-black">
                    {{ user.isActive ? 'Active' : 'Banned' }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <button v-if="user.isActive" @click="toggleBan(user)"
                    class="text-xs font-black px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors border border-red-100">
                    Ban
                  </button>
                  <button v-else @click="toggleBan(user)"
                    class="text-xs font-black px-3 py-1.5 rounded-lg bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-colors border border-green-100">
                    Unban
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
 

          <div v-if="adminStore.pagination && adminStore.pagination.last_page > 1"
            class="flex justify-center gap-2 p-4 border-t border-gray-100">
            <button v-for="page in adminStore.pagination.last_page" :key="page"
              @click="adminStore.fetchUsers(page)"
              :class="[
                'w-9 h-9 rounded-lg text-sm font-bold transition-colors',
                page === adminStore.pagination.current_page
                  ? 'bg-green-500 text-white'
                  : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
              ]">
              {{ page }}
            </button>
          </div>
        </div>
      </div>
 
      <div v-if="activeTab === 'ingredients'" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
 
        <!-- List -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-black text-gray-800">Ingredients</h2>
          </div>
          <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
              <tr>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Name</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Category</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Calories</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="ing in adminStore.ingredients" :key="ing.id" class="hover:bg-gray-50">
                <td class="px-6 py-3 font-bold text-gray-800">{{ ing.name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ ing.ingredient_category?.name ?? '—' }}</td>
                <td class="px-6 py-3 text-gray-500">{{ ing.calories_per_100 }} kcal</td>
                <td class="px-6 py-3 flex gap-2">
                  <button @click="startEditIngredient(ing)"
                    class="text-xs font-black px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors border border-blue-100">
                    Edit
                  </button>
                  <button @click="confirmDelete('ingredient', ing.id)"
                    class="text-xs font-black px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors border border-red-100">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
 
 
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
          <div class="flex justify-between items-center mb-5">
            <h2 class="text-lg font-black text-gray-800">
              {{ editingIngredient ? 'Edit Ingredient' : 'Add Ingredient' }}
            </h2>
            <button v-if="editingIngredient" @click="resetIngredientForm"
              class="text-xs text-gray-400 hover:text-gray-700 font-bold">Cancel</button>
          </div>
 
          <form @submit.prevent="submitIngredient" class="space-y-3">
            <div>
              <label class="block text-xs font-bold text-gray-600 mb-1">Name</label>
              <input v-model="ingredientForm.name" type="text" required
                class="w-full p-2.5 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white text-sm">
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-600 mb-1">Category</label>
              <select v-model="ingredientForm.ingredient_category_id" required
                class="w-full p-2.5 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white text-sm">
                <option :value="null" disabled>Select category</option>
                <option v-for="cat in adminStore.ingredientCategories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div v-for="macro in macroFields" :key="macro.key">
                <label class="block text-xs font-bold text-gray-600 mb-1">{{ macro.label }}</label>
                <input v-model="ingredientForm[macro.key]" type="number" step="0.1" min="0" required
                  class="w-full p-2.5 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white text-sm">
              </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">ml → g</label>
                <input v-model="ingredientForm.ml_to_g" type="number" step="0.01" min="0"
                  class="w-full p-2.5 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white text-sm">
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">piece → g</label>
                <input v-model="ingredientForm.piece_to_g" type="number" step="0.1" min="0"
                  class="w-full p-2.5 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white text-sm">
              </div>
            </div>
            <p v-if="ingredientSuccess" class="text-green-600 text-xs font-bold">✅ {{ ingredientSuccess }}</p>
            <button type="submit"
              class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-2.5 rounded-xl transition-colors text-sm">
              {{ editingIngredient ? 'Save Changes' : 'Add Ingredient' }}
            </button>
          </form>
        </div>
      </div>
 
    
      <div v-if="activeTab === 'ingredientCategories'" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
 
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-black text-gray-800">Ingredient Categories</h2>
          </div>
          <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
              <tr>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Name</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Ingredients</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="cat in adminStore.ingredientCategories" :key="cat.id" class="hover:bg-gray-50">
                <td class="px-6 py-3 font-bold text-gray-800">{{ cat.name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ cat.ingredients?.length ?? 0 }}</td>
                <td class="px-6 py-3 flex gap-2">
                  <button @click="startEditIngredientCategory(cat)"
                    class="text-xs font-black px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors border border-blue-100">
                    Edit
                  </button>
                  <button @click="confirmDelete('ingredientCategory', cat.id)"
                    class="text-xs font-black px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors border border-red-100">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
 
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
          <div class="flex justify-between items-center mb-5">
            <h2 class="text-lg font-black text-gray-800">
              {{ editingIngredientCategory ? 'Edit Category' : 'Add Category' }}
            </h2>
            <button v-if="editingIngredientCategory" @click="resetIngredientCategoryForm"
              class="text-xs text-gray-400 hover:text-gray-700 font-bold">Cancel</button>
          </div>
          <form @submit.prevent="submitIngredientCategory" class="space-y-3">
            <div>
              <label class="block text-xs font-bold text-gray-600 mb-1">Name</label>
              <input v-model="ingredientCategoryForm.name" type="text" required
                class="w-full p-2.5 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white text-sm">
            </div>
            <p v-if="ingredientCategorySuccess" class="text-green-600 text-xs font-bold">✅ {{ ingredientCategorySuccess }}</p>
            <button type="submit"
              class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-2.5 rounded-xl transition-colors text-sm">
              {{ editingIngredientCategory ? 'Save Changes' : 'Add Category' }}
            </button>
          </form>
        </div>
      </div>
 
    
      <div v-if="activeTab === 'recipeCategories'" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
 
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-black text-gray-800">Recipe Categories</h2>
          </div>
          <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
              <tr>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Name</th>
                <th class="text-left px-6 py-3 text-gray-400 font-black uppercase text-xs">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="cat in adminStore.recipeCategories" :key="cat.id" class="hover:bg-gray-50">
                <td class="px-6 py-3 font-bold text-gray-800">{{ cat.name }}</td>
                <td class="px-6 py-3 flex gap-2">
                  <button @click="startEditRecipeCategory(cat)"
                    class="text-xs font-black px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors border border-blue-100">
                    Edit
                  </button>
                  <button @click="confirmDelete('recipeCategory', cat.id)"
                    class="text-xs font-black px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors border border-red-100">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
 
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
          <div class="flex justify-between items-center mb-5">
            <h2 class="text-lg font-black text-gray-800">
              {{ editingRecipeCategory ? 'Edit Category' : 'Add Category' }}
            </h2>
            <button v-if="editingRecipeCategory" @click="resetRecipeCategoryForm"
              class="text-xs text-gray-400 hover:text-gray-700 font-bold">Cancel</button>
          </div>
          <form @submit.prevent="submitRecipeCategory" class="space-y-3">
            <div>
              <label class="block text-xs font-bold text-gray-600 mb-1">Name</label>
              <input v-model="recipeCategoryForm.name" type="text" required
                class="w-full p-2.5 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white text-sm">
            </div>
            <p v-if="recipeCategorySuccess" class="text-green-600 text-xs font-bold">✅ {{ recipeCategorySuccess }}</p>
            <button type="submit"
              class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-2.5 rounded-xl transition-colors text-sm">
              {{ editingRecipeCategory ? 'Save Changes' : 'Add Category' }}
            </button>
          </form>
        </div>
      </div>
 
    </div>
  </div>
</template>
 
<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useAdminStore } from '../stores/admin';
 
const router     = useRouter();
const authStore  = useAuthStore();
const adminStore = useAdminStore();
 
const activeTab = ref('users');
 
const tabs = [
    { id: 'users',                label: 'Users',                 icon: '👥' },
    { id: 'ingredients',          label: 'Ingredients',           icon: '🥦' },
    { id: 'ingredientCategories', label: 'Ingredient Categories', icon: '📂' },
    { id: 'recipeCategories',     label: 'Recipe Categories',     icon: '🍽️' },
];
 
const statCards = [
    { key: 'total_users',        label: 'Total Users',   icon: '👥' },
    { key: 'total_recipes',      label: 'Recipes',       icon: '📖' },
    { key: 'total_ingredients',  label: 'Ingredients',   icon: '🥦' },
    { key: 'new_users_week',     label: 'New This Week', icon: '🆕' },
    { key: 'recipes_this_week',  label: 'New Recipes',   icon: '✨' },
    { key: 'banned_users',       label: 'Banned',        icon: '🚫' },
];
 
const macroFields = [
    { key: 'calories_per_100', label: 'Calories (kcal)' },
    { key: 'protein_per_100',  label: 'Protein (g)'     },
    { key: 'carbs_per_100',    label: 'Carbs (g)'       },
    { key: 'fat_per_100',      label: 'Fat (g)'         },
];
 

const toggleBan = async (user) => {
    const action = user.isActive ? 'ban' : 'unban';
    if (!confirm(`Are you sure you want to ${action} ${user.username}?`)) return;
    if (user.isActive) {
        await adminStore.banUser(user.id);
    } else {
        await adminStore.unbanUser(user.id);
    }
};
 

const editingIngredient  = ref(null);
const ingredientSuccess  = ref('');
const ingredientForm     = ref({
    name: '', ingredient_category_id: null,
    calories_per_100: null, protein_per_100: null,
    carbs_per_100: null, fat_per_100: null,
    ml_to_g: null, piece_to_g: null,
});
 
const startEditIngredient = (ing) => {
    editingIngredient.value = ing.id;
    ingredientForm.value = {
        name:                   ing.name,
        ingredient_category_id: ing.ingredient_category_id,
        calories_per_100:       ing.calories_per_100,
        protein_per_100:        ing.protein_per_100,
        carbs_per_100:          ing.carbs_per_100,
        fat_per_100:            ing.fat_per_100,
        ml_to_g:                ing.ml_to_g,
        piece_to_g:             ing.piece_to_g,
    };
};
 
const resetIngredientForm = () => {
    editingIngredient.value = null;
    ingredientSuccess.value = '';
    ingredientForm.value = {
        name: '', ingredient_category_id: null,
        calories_per_100: null, protein_per_100: null,
        carbs_per_100: null, fat_per_100: null,
        ml_to_g: null, piece_to_g: null,
    };
};
 
const submitIngredient = async () => {
    ingredientSuccess.value = '';
    let result;
    if (editingIngredient.value) {
        result = await adminStore.updateIngredient(editingIngredient.value, ingredientForm.value);
        if (result) { ingredientSuccess.value = 'Ingredient updated!'; resetIngredientForm(); }
    } else {
        result = await adminStore.createIngredient(ingredientForm.value);
        if (result) { ingredientSuccess.value = `"${result.data.name}" added!`; resetIngredientForm(); }
    }
};

const editingIngredientCategory  = ref(null);
const ingredientCategorySuccess  = ref('');
const ingredientCategoryForm     = ref({ name: '' });
 
const startEditIngredientCategory = (cat) => {
    editingIngredientCategory.value = cat.id;
    ingredientCategoryForm.value = { name: cat.name };
};
 
const resetIngredientCategoryForm = () => {
    editingIngredientCategory.value = null;
    ingredientCategorySuccess.value = '';
    ingredientCategoryForm.value = { name: '' };
};
 
const submitIngredientCategory = async () => {
    ingredientCategorySuccess.value = '';
    let result;
    if (editingIngredientCategory.value) {
        result = await adminStore.updateIngredientCategory(editingIngredientCategory.value, ingredientCategoryForm.value);
        if (result) { ingredientCategorySuccess.value = 'Category updated!'; resetIngredientCategoryForm(); }
    } else {
        result = await adminStore.createIngredientCategory(ingredientCategoryForm.value);
        if (result) { ingredientCategorySuccess.value = `"${result.data.name}" added!`; resetIngredientCategoryForm(); }
    }
};
 

const editingRecipeCategory  = ref(null);
const recipeCategorySuccess  = ref('');
const recipeCategoryForm     = ref({ name: '' });
 
const startEditRecipeCategory = (cat) => {
    editingRecipeCategory.value = cat.id;
    recipeCategoryForm.value = { name: cat.name };
};
 
const resetRecipeCategoryForm = () => {
    editingRecipeCategory.value = null;
    recipeCategorySuccess.value = '';
    recipeCategoryForm.value = { name: '' };
};
 
const submitRecipeCategory = async () => {
    recipeCategorySuccess.value = '';
    let result;
    if (editingRecipeCategory.value) {
        result = await adminStore.updateRecipeCategory(editingRecipeCategory.value, recipeCategoryForm.value);
        if (result) { recipeCategorySuccess.value = 'Category updated!'; resetRecipeCategoryForm(); }
    } else {
        result = await adminStore.createRecipeCategory(recipeCategoryForm.value);
        if (result) { recipeCategorySuccess.value = `"${result.data.name}" added!`; resetRecipeCategoryForm(); }
    }
};
 

const confirmDelete = async (type, id) => {
    if (!confirm('Are you sure you want to delete this? This cannot be undone.')) return;
    if (type === 'ingredient')         await adminStore.deleteIngredient(id);
    if (type === 'ingredientCategory') await adminStore.deleteIngredientCategory(id);
    if (type === 'recipeCategory')     await adminStore.deleteRecipeCategory(id);
};
 

onMounted(async () => {
    if (!authStore.user) await authStore.checkAuth();
 
    if (authStore.user?.role?.name !== 'admin') {
        router.push({ name: 'dashboard' });
        return;
    }
 
    adminStore.fetchStats();
    adminStore.fetchUsers();
    adminStore.fetchIngredients();
    adminStore.fetchIngredientCategories();
    adminStore.fetchRecipeCategories();
});
</script>