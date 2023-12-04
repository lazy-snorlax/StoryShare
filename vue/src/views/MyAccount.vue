<template>
    <Header :title="'My Account'" />

    <!-- My Account Nav? -->
    <ul class="nav nav-horizontal">
        <li class="nav-item active">
            <router-link to="/my-account" class="nav-link active"> Details </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/my-account/security" class="nav-link"> Security </router-link>
        </li>
    </ul>

    <RouterView v-if="loggedInUser?.id" />
</template>
    
<script lang="ts" setup>
import { useLoggedInUser } from '../composables/use-logged-in-user';
const { loggedInUser } = useLoggedInUser()
</script>