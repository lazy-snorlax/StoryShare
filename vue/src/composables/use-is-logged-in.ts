import { useAuthStore } from '../stores/auth'
import { storeToRefs } from 'pinia'
import { computed } from 'vue'

export function useIsLoggedIn() {
  const authStore = useAuthStore()
  const { user } = storeToRefs(authStore)

  return {
    isLoggedIn: computed(() => user.value !== null),
    getLoggedInUser: authStore.getUser,
  }
}
