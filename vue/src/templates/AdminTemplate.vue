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
import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'
import { onMounted } from 'vue'
import { useLoggedInUser } from '../composables/use-logged-in-user'
import { changeTheme } from '../composables/change-theme'

const { loggedInUser } = useLoggedInUser()
const authStore = useAuthStore()
const { is_expanded } = storeToRefs(authStore)

const { loadTheme } = changeTheme()

onMounted(() => {
  let className = document.querySelector('#page-content-wrapper')?.className
  if (loggedInUser?.value.preferences?.defaultDark && className == "dark") {
    loadTheme(loggedInUser?.value.preferences.defaultDark)
  }
})
</script>