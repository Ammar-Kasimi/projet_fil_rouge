<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { onMounted } from 'vue';
axios.defaults.baseURL = "localhost:8000/api"
console.log(axios)
const name = ref(null)
async function register() {
    try{
        respo = axios.post('/register',{
            name : name.value
        })
    }
    catch{

    }
}
onMounted(()=>{
   
})
</script>

<template>
    axiiiios
</template>