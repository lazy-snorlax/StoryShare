<template>
  <div id="wrapper">
    <Sidebar />

    <div id="page-content-wrapper" class="dark">
      <RouterView v-slot="{ Component }">
        <template v-if="Component">
          <Suspense :timeout="0">
            <component :is="Component" />
          </Suspense>
        </template>
      </RouterView>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import Sidebar from '../components/app/Sidebar.vue'
  // import axios from 'axios'
  
  // const user = ref();
  // onMounted(async () => {
  //   const data = await axios.get('api/user')
  //   console.log(data)
  // })
  
</script>