<template>
    <header v-if="loggedInUser != null && !loggedInUser.email_verified" class="page-header verify-email">
        <span class="">
            Your email is un-verified. Please click the link that was sent to your email. If you need to re-send the link, <a class="link-underline-primary" @click="resend">click here</a>
        </span>
    </header>
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
import { useAuthStore } from '@/stores/auth'
import { useIsLoggedIn } from '@/composables/use-is-logged-in'
import { useLoggedInUser } from '@/composables/use-logged-in-user'

const props = defineProps<{
    title?: string|null,
    subtitle?: string|null,
}>()

const { getLoggedInUser } = useIsLoggedIn()
const { loggedInUser } = useLoggedInUser()

const { toggleSidebar, resendVerifyEmail } = useAuthStore()

const sidebarToggle = () => {
    const wrapper = document.getElementById('wrapper')
    toggleSidebar()
    wrapper.classList.add('transitioning')
    
    setTimeout(() => { 
        wrapper.classList.remove('transitioning')
    }, 300)
}

const resend = async() => {
    resendVerifyEmail()
    alert('Verification email has been re-sent')
}

</script>