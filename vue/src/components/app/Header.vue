<template>
    <header class="page-header sticky pb-0">
        <div class="menu-toggle-wrap">
            <button class="menu-toggle" @click="sidebarToggle">
                <font-awesome-icon icon="fa-solid fa-bars"></font-awesome-icon>
            </button>
        </div>
        <div v-if="loggedInUser != null">
            <p>{{ loggedInUser.email }}</p>
        </div>
    </header>
    <header class="page-header">
        <div class="d-flex text-center w-100">
            <div class="page-title mx-3 my-3 text-center">
                <h1>{{ title }}</h1>
                <p v-if="subtitle" class="subheading">{{ subtitle }}</p>
            </div>
        </div>
    </header>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'
import { useIsLoggedIn } from '@/composables/use-is-logged-in'
import { useLoggedInUser } from '@/composables/use-logged-in-user';

const props = defineProps<{
    title?: string|null,
    subtitle?: string|null,
}>()

const { getLoggedInUser } = useIsLoggedIn()
const { loggedInUser } = useLoggedInUser()

const { toggleSidebar } = useAuthStore()

const sidebarToggle = () => {

    const wrapper = document.getElementById('wrapper')
    toggleSidebar()
    wrapper.classList.add('transitioning')
    
    setTimeout(() => { 
        wrapper.classList.remove('transitioning')
    }, 300)
}

</script>