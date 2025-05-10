<template>
    <Header :title="'My Account'" />

    <!-- My Account Nav? -->
    <ul class="my-account nav nav-horizontal">
        <li class="nav-item" :class="{ active: $route.name === 'my-account' }">
            <router-link :to="{ name: 'my-account' }" class="nav-link"> Details </router-link>
        </li>
        <li class="nav-item" :class="{ active: $route.name === 'my-account.preferences' }">
            <router-link :to="{ name: 'my-account.preferences' }" class="nav-link"> Preferences </router-link>
        </li>
        <li class="nav-item" :class="{ active: $route.name === 'my-account.security' }">
            <router-link :to="{ name: 'my-account.security' }" class="nav-link"> Security </router-link>
        </li>
        <!-- TODO: -->
        <!-- <li class="nav-item" >
            <a class="nav-link"> Skins </a>
        </li> -->
    </ul>

    <RouterView v-if="loggedInUser?.id" />
</template>
    
<script lang="ts" setup>
import { ref } from 'vue';
import { useLoggedInUser } from '../../composables/use-logged-in-user';

const { loggedInUser } = useLoggedInUser()

const headerKey = ref(0)
const forceRerender = () => {
    headerKey.value += 1
}

</script>