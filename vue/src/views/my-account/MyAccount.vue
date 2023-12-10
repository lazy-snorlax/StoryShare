<template>
    <Header :title="'My Account'" />

    <!-- My Account Nav? -->
    <ul class="nav nav-horizontal">
        <li class="nav-item" :class="{ active: $route.name === 'my-account' }">
            <router-link :to="{ name: 'my-account' }" class="nav-link"> Details </router-link>
        </li>
        <li class="nav-item" :class="{ active: $route.name === 'my-account.security' }">
            <router-link :to="{ name: 'my-account.security' }" class="nav-link"> Security </router-link>
        </li>
        <!-- TODO: -->
        <!-- <li class="nav-item" >
            <a class="nav-link"> Preferences </a>
        </li>
        <li class="nav-item" >
            <a class="nav-link"> Skins </a>
        </li> -->
    </ul>

    <RouterView v-if="loggedInUser?.id" />
</template>
    
<script lang="ts" setup>
import { useLoggedInUser } from '../../composables/use-logged-in-user';

const { loggedInUser } = useLoggedInUser()

</script>