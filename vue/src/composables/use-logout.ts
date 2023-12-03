import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

export function useLogout() {
  const router = useRouter()
  const app = useAuthStore()

  const logout = async () => {
    await app.logout()

    router.replace({ name: 'login' })
  }

  return {
    logout,
  }
}
