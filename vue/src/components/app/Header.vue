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
        <div v-if="isLoggedIn" class="loggedin-avatar">
            <div class="dropdown">
                <button class="dropbtn">
                    <div class="avatar-border">
                        <Avatar :name="loggedInUser?.name" :imgSrc="imgSrc" :imgSize="60" />
                    </div>
                    <p class="my-auto ms-2">{{ loggedInUser?.email }}</p>
                </button>
                <div class="dropdown-content">
                    <router-link class="rounded-top" :to="{ name:'profile', params: { id: loggedInUser?.id } }">
                        <span class="text">Profile</span>
                    </router-link>
                    <router-link class="" :to="{ name:'my-account.preferences' }">
                        <span class="text">Preferences</span>
                    </router-link>
                    <router-link class="rounded-bottom" :to="{ name:'my-account.security' }">
                        <span class="text">Security</span>
                    </router-link>
                </div>
            </div>
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
import { useProfile } from '../../composables/get-profile' 
import { useIsLoggedIn } from '@/composables/use-is-logged-in'
import { useLoggedInUser } from '@/composables/use-logged-in-user'
import { toast } from 'vue3-toastify';

import Avatar from '@/components/user/Avatar.vue';
import { computed, ref } from 'vue';
import { rand } from '@vueuse/core';

const props = defineProps<{
    headerKey?: Number | null,
    title?: string|null,
    subtitle?: string|null,
}>()

const { isLoggedIn } = useIsLoggedIn()
const { loggedInUser } = useLoggedInUser()
const { toggleSidebar, resendVerifyEmail } = useAuthStore()
const { rerender } = useProfile()

const imgSrc = computed(()=> {
    if (rerender.value > 0) {
        return import.meta.env.VITE_API_URL + loggedInUser.value.imgSrc + '?r=' + rerender.value
    }
    return import.meta.env.VITE_API_URL + loggedInUser.value.imgSrc
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

<style lang="scss">
.loggedin-avatar {
    color: var(--light);
    border-radius: 5%;
    padding: 0.5rem 0.75rem;
    margin-bottom: 5px;

    .dropdown {
        position: relative;
    }
    .dropbtn {
        display: flex;
        padding: 0.25rem;
        font-size: 16px;
        border: none;
        color: var(--primary);
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: transparent;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    
    .dropdown-content a {
        background-color: var(--dark);
        color: var(--light-alt);
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover { 
        background-color: var(--light-alt);
        color: var(--dark-alt);
    }

    .dropdown:hover .dropdown-content { 
        display: block;
    }
}

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
    width: 3rem;
    height: 3rem;
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