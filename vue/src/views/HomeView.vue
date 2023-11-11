<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const user = ref();
onMounted(async () => {
  const data = await axios.get('api/user')
  console.log(data)
})

</script>

<template>
  <main id="home-page">
    <h1>Home</h1>
    <p>This is the home page</p>
  </main>
</template>
