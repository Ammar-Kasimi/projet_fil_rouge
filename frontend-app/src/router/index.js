import { createRouter, createWebHistory } from 'vue-router';


import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import DashboardView from '../views/DashboardView.vue'
import SearchView from '../views/SearchView.vue'
import CatalogView from '../views/CatalogView.vue'
import CreateRecipeView from '../views/CreateRecipeView.vue';
import FridgeView from '../views/FridgeView.vue';
import RecipeDetailView from '../views/RecipeDetailView.vue';
import EditRecipeView from '../views/EditRecipeView.vue';
import AdminView from '../views/AdminView.vue';
import { useAuthStore } from '../stores/auth';

const routes = [
    { path: '/', redirect: '/login' },
    { path: '/login', name: 'login', component: LoginView },
    { path: '/dashboard', name: 'dashboard', component: DashboardView },
    { path: '/register', name: 'register', component: RegisterView },
    { path: '/search', name: 'search', component: SearchView },
    { path: '/catalog', name: 'catalog', component: CatalogView },
    { path: '/create-recipe', name: 'createRecipe', component: CreateRecipeView },
    { path: '/fridge', name: 'fridge', component: FridgeView },
    { path: '/recipe/:id', name: 'recipeDetail', component: RecipeDetailView },
    { path: '/recipe/:id/edit', name: 'editRecipe', component: EditRecipeView },
    { path: '/admin', name: 'admin', component: AdminView, meta: { requiresAuth: true, requiresAdmin: true } },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});
router.beforeEach(async (to, from) => {
    const authStore = useAuthStore();
    if (!authStore.user) {
        await authStore.checkAuth();
    }

    const user = authStore.user;
    const isAdmin = user?.role?.name === 'admin';
    if (to.path.startsWith('/admin') && !isAdmin) {
        return { name: 'catalog' };
    }
    const publicRoutes = ['login', 'register', 'dashboard','editRecipe','recipeDetail','fridge','createRecipe','catalog'];
    if (!publicRoutes.includes(to.name) && !user) {
        return { name: 'login' };
    }
});
export default router;