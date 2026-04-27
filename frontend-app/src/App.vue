<template>
  <div class="container">
    <h1>Shared Expenses</h1>
    
    <input v-model="newExpense" placeholder="What did you buy?" />
    
    <button @click="addExpense">Add to List</button>

    <ul>
      <li v-for="item in expenses" :key="item">
        {{ item }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// ref() tells Vue: "Watch this variable! If it changes, update the screen instantly."
const newExpense = ref(''); 
const expenses = ref(['Rent', 'Groceries']); // Starting with some dummy data

// A simple function to add the typed text into our array
const addExpense = () => {
  if (newExpense.value !== '') {
    expenses.value.push(newExpense.value); // .value is required when changing a ref() in the script!
    newExpense.value = ''; // This instantly clears the input box on the screen
  }
};
</script>

<style scoped>
.container { font-family: sans-serif; padding: 20px; }
input { padding: 8px; margin-right: 10px; }
button { padding: 8px 15px; cursor: pointer; }
</style>