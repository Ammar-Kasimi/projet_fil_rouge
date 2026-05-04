import { createApp } from 'vue'
// import './style.css'
import App from './App.vue'
import router from './router'
import './assets/main.css'
import axios from 'axios'

import { createPinia } from 'pinia'




axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true 

const app= createApp(App)
app.use(createPinia())
app.use(router)
app.mount("#app")