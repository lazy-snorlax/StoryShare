<template>
  <h1>Registration Complete</h1>

  <template v-if="loggedInUser">
    <p>Welcome to Story Share</p>

    <p>Click below to return to the dashboard</p>

    <a class="btn btn-primary btn-lg w-100" @click.prevent="complete">
      Take me to my company portal
    </a>
  </template>
  <p v-else>
    Thanks for creating an account.
  </p>
</template>

<script lang="ts" setup>
import { useLoggedInUser } from '@/composables/use-logged-in-user'
// import { useAppStore } from '@/stores/app'

// const appStore = useAppStore()
const { loggedInUser } = useLoggedInUser()

async function complete() {
  const url = loggedInUser.value.registration_company_url!

  // Log the user out of the subscription portal as they have completed their registration.
  // await appStore.logout()

  // Redirect the user to their company portal.
  window.location.replace(url)
}
</script>
