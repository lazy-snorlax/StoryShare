import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

export function useLogout() {
  const router = useRouter()
  const auth = useAuthStore()

  const logout = async () => {
    await auth.logout()

    // TODO: Alert for successful logout

    router.replace({ name: 'dashboard' })
  }

  return {
    logout,
  }
}
