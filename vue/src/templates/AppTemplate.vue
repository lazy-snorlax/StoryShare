<template>
  <div id="wrapper" :class="`${is_expanded ? 'toggled' : ''}`">
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

  <ModalsContainer />
</template>

<script lang="ts" setup>
import { ModalsContainer, useModal } from 'vue-final-modal'
import Sidebar from '../components/app/Sidebar.vue'
import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'
import { onMounted, onUnmounted } from 'vue'
import { useLoggedInUser } from '../composables/use-logged-in-user'

const { loggedInUser } = useLoggedInUser()
const authStore = useAuthStore()
const { is_expanded } = storeToRefs(authStore)

onMounted(() => {
  let className = document.querySelector('#page-content-wrapper')?.className
  if (loggedInUser?.value.preferences.defaultDark && className == "dark") {
    console.log(">>> Loading dark theme....", loggedInUser?.value.preferences.defaultDark)
    loadTheme(loggedInUser?.value.preferences.defaultDark)
  }
})

const loadTheme = (themeIdx) => {
  const theme = loggedInUser?.value.preferences.themes[themeIdx]
  changeColour('--primary', theme["primary"])
  changeColour('--primary-alt', theme["primaryAlt"])
  changeColour('--light', theme["light"])
  changeColour('--light-alt', theme["lightAlt"])
  changeColour('--dark', theme["dark"])
  changeColour('--dark-alt', theme["darkAlt"])
  
  changeColour('--white', theme["white"])
  changeColour('--grey', theme["grey"])
  changeColour('--black', theme["black"])
}

const changeColour = (prop, color) => { 
  document.documentElement.style.setProperty(prop, color)
}

</script>