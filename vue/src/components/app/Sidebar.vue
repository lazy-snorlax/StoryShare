<template>
    <div id="sidebar-wrapper" :class="`${!is_expanded ? 'expanded' : ''}`">
        <div class="logo">
            <img :src="logo" alt="LOGO.png">
			<h5 v-if="!is_expanded">STORY SHARE</h5>
        </div>

        <!-- <h3>Menu</h3> -->

        <div class="menu">
			<router-link :to="{ name: 'stories.search' }" class="button mt-3">
				<font-awesome-icon icon="magnifying-glass"></font-awesome-icon> <span class="text"> Browse </span>
			</router-link> 
            <router-link :to="{ name: 'dashboard' }" class="button">
				<font-awesome-icon icon="fa-solid fa-table-columns"></font-awesome-icon>
				<span class="text">Dashboard</span>
            </router-link>
        </div>
		
        <div class="menu flex">
			<template v-if="isLoggedIn">
				<router-link 
					class="button"
					:to="{ name: 'my-stories' }"
					:class="{'router-link-exact-active': $route.name.toString().includes('my-stories')}"
					>
					<i class="fa-solid fa-book-open-reader"></i> 
					<span class="text">My Stories</span>
				</router-link>
				<router-link 
					class="button" 
					:to="{ name: 'my-bookmarks' }" 
					:class="{'router-link-exact-active': $route.name.toString().includes('my-bookmarks')}">
					<i class="fa-solid fa-bookmark"></i> 
					<span class="text">My Bookmarks</span>
				</router-link>
				<a class="button">
					<i class="fa-solid fa-layer-group"></i> <span class="text">My Collections</span>
				</a>
				<a class="button">
					<i class="fa-solid fa-file"></i> <span class="text">Drafts</span>
				</a>
				<a class="button">
					<i class="fa-solid fa-chart-simple"></i> <span class="text">Metrics</span>
				</a>
			</template>
		</div>

		<div class="menu flex">
			<template v-if="isLoggedIn && loggedInUser?.role?.name == 'admin'">
				<router-link :to="{ name: 'admin.dashboard' }" class="button">
					<font-awesome-icon icon="fa-solid fa-user-tie"></font-awesome-icon>
					<span class="text">Admin Dashboard</span>
				</router-link>
				<router-link :to="{ name: 'admin.users.list' }" class="button">
					<font-awesome-icon icon="fa-solid fa-users"></font-awesome-icon> <span class="text">Users</span>
				</router-link>
				<a class="button">
					<i class="fa-solid fa-tags"></i> <span class="text">Tags</span>
				</a>
				<a class="button">
					<i class="fa-solid fa-flag"></i> <span class="text">Reports</span>
				</a>
			</template>
		</div>
		
		<div class="menu">
			<template v-if="isLoggedIn">
				<router-link 
					class="button" 
					:to="{ name:'my-account' }" 
					:class="{ 'router-link-exact-active': $route.name.toString().includes('my-account') }">
					<font-awesome-icon icon="fa-solid fa-gear"></font-awesome-icon> <span class="text">Settings</span>
				</router-link>
				<a class="button" @click="logout">
					<font-awesome-icon icon="fa-solid fa-user"></font-awesome-icon> <span class="text">Logout</span>
				</a>
			</template>
			<template v-else>
				<router-link class="button" :to="{ name:'login' }">
					<font-awesome-icon icon="fa-solid fa-user"></font-awesome-icon> <span class="text">Login</span>
				</router-link>
			</template>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { computed, reactive, watchEffect } from 'vue'
import logoDefault from '@/assets/logo.svg'
import { useLogout } from '@/composables/use-logout'
import { useIsLoggedIn } from '@/composables/use-is-logged-in'
import { useLoggedInUser } from '@/composables/use-logged-in-user'

import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'

import ThemeButton from './utilities/ThemeButton.vue'

import { useModal } from 'vue-final-modal'
import ModalLogin from '../../components/app/ModalLogin.vue'

const logo = computed(() => { return logoDefault })

const { logout } = useLogout()
const { isLoggedIn } = useIsLoggedIn()
const { loggedInUser } = useLoggedInUser()

const authStore = useAuthStore()
const { is_expanded } = storeToRefs(authStore)

const { open, close } = useModal({
	component: ModalLogin,
	attrs: {
		onSubmit(formData) {
			try {
				close()
			} catch (error) {
				console.log('>>> ', error)
			}
		},
	},
})


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

<style scoped>

p {
  color: var(--text-primary-color);
}

.container-center {
  background-color: var(--background-color-primary);
  height: 100vh;
  width: 100vw;
  display: flex;
  align-items: center;
  justify-content: center;
}

.card {
  padding: 2rem 4rem;
  height: 200px;
  width: 300px;
  text-align: center;
  border: 1px solid var(--accent-color);
  border-radius: 4px;
  background-color: var(--background-color-secondary);
}

.close-sidebar {
	display: none;
}

@media (max-width: 1024px) {
	.close-sidebar {	
		display: block;
		margin-left: auto;
		font-size: 20px;
	}
}

</style>