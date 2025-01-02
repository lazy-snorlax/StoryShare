import { useAuthStore, type LoggedInUserResource } from '../stores/auth'
import { storeToRefs } from 'pinia'
import type { Ref } from 'vue'
import { defineAbility } from '@casl/ability'

export function useLoggedInUser() {
  const authStore = useAuthStore()
  const { user } = storeToRefs(authStore)

  // Loudly fail if there is no logged in user so we can safely return the logged in user type without any possibility for a null value. 
  // To check if a user is logged in use the "isLoggedIn" composable.
  if (user.value === null) {
    // throw new Error('No logged in user.')
    return {
      loggedInUser: null
    }
  }

  const abilities = user.value.abilities as { name: string }[]
  const ability = defineAbility((can) => {
    abilities.forEach(({ name }) => can(name, '*'))
  })

  return {
    loggedInUser: user as Ref<LoggedInUserResource>,
    can: (action: string) => ability.can(action, '*'),
    cannot: (action: string) => ability.cannot(action, '*'),
    getLoggedInUser: authStore.getUser(),
  }
}
