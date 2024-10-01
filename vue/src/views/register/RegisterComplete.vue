<template>
  <div class="card card-authentication">
    <div class="card-body p-5">
      <h1>Registration Complete</h1>
      
      <template v-if="loggedInUser">
        <p>Welcome to Story Share</p>
        <p>Click below to return to the dashboard</p>
      </template>
      <p v-else>
        Thanks for creating an account.
      </p>
      <router-link :to="{ name: 'dashboard' }">
        <button class="btn btn-primary">Proceed to Dashboard</button>
      </router-link>
      
    </div>
  </div>
</template>

<script lang="ts" setup>
import { useLoggedInUser } from '@/composables/use-logged-in-user'
// import { useAppStore } from '@/stores/app'

// const appStore = useAppStore()
const { loggedInUser } = useLoggedInUser()

</script>
