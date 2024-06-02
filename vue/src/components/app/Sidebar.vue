<template>
    <div id="sidebar-wrapper" :class="`${is_expanded ? 'is-expanded' : ''}`">
        <div class="logo">
            <img :src="logo" alt="LOGO.png">
        </div>

        <h3>Menu</h3>

        <div class="menu">
			<router-link :to="{ name: 'stories.search' }" class="button">
				<font-awesome-icon icon="magnifying-glass"></font-awesome-icon> <span class="text"> Browse </span>
			</router-link> 
            <router-link :to="{ name: 'dashboard' }" class="button">
				<font-awesome-icon icon="fa-solid fa-table-columns"></font-awesome-icon>
				<span class="text">Dashboard</span>
            </router-link>
			<template v-if="isLoggedIn">
				<router-link 
					class="button" 
					:to="{ name:'my-account' }" 
					:class="{ 'router-link-exact-active': $route.name.toString().includes('my-account') }">
					<font-awesome-icon icon="fa-solid fa-user"></font-awesome-icon> <span class="text">My Account</span>
				</router-link>
			</template>
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
					<i class="fa-solid fa-books"></i> <span class="text">Serials</span>
				</a>
				<a class="button">
					<i class="fa-solid fa-file"></i> <span class="text">Drafts</span>
				</a>
			</template>
			<!-- <router-link to="/Collections" class="button">
				<i class="fa-solid fa-layer-group"></i> <span class="text">Collections</span>
			</router-link>
			<router-link to="/Prompts" class="button">
				<i class="fa-regular fa-comment-dots"></i> <span class="text">Prompts</span>
			</router-link> -->
		</div>

		<!-- <div class="menu flex">
			<template v-if="isLoggedIn">
				<a class="button">
					<i class="fa-solid fa-comment-dots"></i> <span class="text"> Outlines </span>
				</a>
				<a class="button">
					<i class="fa-solid fa-comment-dots"></i> <span class="text"> Character Creator </span>
				</a>
				<a class="button">
					<i class="fa-solid fa-comment-dots"></i> <span class="text"> Prompts </span>
				</a>
			</template>
		</div> -->

        <div class="menu">
			<a class="button" v-if="isLoggedIn">
				<i class="fa-solid fa-chart-simple"></i> <span class="text">Metrics</span>
			</a>
			<a class="button" @click="logout" v-if="isLoggedIn">
				<font-awesome-icon icon="fa-solid fa-user"></font-awesome-icon> <span class="text">Logout</span>
			</a>
			<router-link 
				v-else
				class="button" 
				:to="{ name:'login' }" 
				>
                <font-awesome-icon icon="fa-solid fa-user"></font-awesome-icon> <span class="text">Login</span>
            </router-link>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import logoDefault from '@/assets/logo.svg'
import { useLogout } from '@/composables/use-logout'
import { useIsLoggedIn } from '@/composables/use-is-logged-in'

import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'

const logo = computed(() => {
	return logoDefault
})

const { logout } = useLogout()
const { isLoggedIn } = useIsLoggedIn()

const authStore = useAuthStore()
const { is_expanded } = storeToRefs(authStore)

</script>