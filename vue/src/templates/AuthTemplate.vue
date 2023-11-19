<template>
  <div class="auth container-fluid">
    <Suspense>
      <RouterView />
    </Suspense>
  </div>  
</template>

<script lang="ts" setup>
  import { ref, onMounted, onUnmounted } from 'vue'
  import Sidebar from '../components/app/Sidebar.vue'
  // import Header from '../components/app/Header.vue';
  // import axios from 'axios'
  
  // const user = ref();
  // onMounted(async () => {
  //   const data = await axios.get('api/user')
  //   console.log(data)
  // })
  
</script>