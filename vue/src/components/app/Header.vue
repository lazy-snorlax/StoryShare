<template>
    <template v-if="isLoggedIn">
        <header v-if="!loggedInUser?.email_verified" class="page-header verify-email">
            <span class="">
                Your email is un-verified. Please click the link that was sent to your email. If you need to re-send the link, <a class="link-underline-primary" @click="resend">click here</a>
            </span>
        </header>
    </template>
    <header class="page-header sticky pb-0">
        <div class="menu-toggle-wrap">
            <button class="menu-toggle" @click="sidebarToggle">
                <font-awesome-icon icon="fa-solid fa-bars"></font-awesome-icon>
            </button>
        </div>
        <div v-if="isLoggedIn">
            <div class="avatar-border">
                <Avatar v-if="loggedInUser?.profile.avatar" :name="loggedInUser?.name" :avatar="loggedInUser?.profile?.avatar" :imgSrc="imgSrc" />
                <Avatar v-else :name="loggedInUser?.name" />
            </div>
            <p class="mb-0 ms-2">{{ loggedInUser?.email }}</p>
        </div>
    </header>
    <header class="page-header" v-if="title != null && title != ''">
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
import { toast } from 'vue3-toastify';

import Avatar from '@/components/user/Avatar.vue';
import { computed } from 'vue';

const props = defineProps<{
    title?: string|null,
    subtitle?: string|null,
}>()

const { isLoggedIn } = useIsLoggedIn()
const { loggedInUser } = useLoggedInUser()

const { toggleSidebar, resendVerifyEmail } = useAuthStore()

const imgSrc = computed(() => {
    return import.meta.env.VITE_API_URL + `profile-image/${loggedInUser?.value.id}`
})

const sidebarToggle = () => {
    const wrapper = document.getElementById('wrapper')
    toggleSidebar()
    wrapper.classList.add('transitioning')
    
    setTimeout(() => { 
        wrapper.classList.remove('transitioning')
    }, 300)
}

const resend = async() => {
    try {
        resendVerifyEmail()
        toast("Verification email has been re-sent", {
            autoClose: 1500,
            position: toast.POSITION.TOP_CENTER,
            theme: 'colored',
            type: 'info'
        })
    } catch (error) {
        toast("Verification email could not re-sent", {
            autoClose: 1500,
            position: toast.POSITION.TOP_CENTER,
            theme: 'colored',
            type: 'error'
        })
        console.error(error)
    }
}
</script>

<style>
.avatar-border {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--primary);
    clip-path: circle();
    width: 3.5rem;
    height: 3.5rem;
}

.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--dark);
    font-size: 1.15rem;
    color: var(--light);
    font-weight: 500;
    width: 10rem;
    height: 10rem;
    clip-path: circle();
    margin: 0 auto;
}

.avatar.avatar-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--dark);
    font-size: 1.15rem;
    color: var(--light);
    font-weight: 500;
    width: 3rem;
    height: 3rem;
    clip-path: circle();
    margin: 0 auto;
}

</style>