<template>
    <div id="sidebar-wrapper" :class="`${is_expanded ? 'is-expanded' : ''}`">
        <div class="logo">
            <img :src="logo" alt="LOGO.png">
        </div>

        <div class="menu-toggle-wrap">
            <button class="menu-toggle" @click="toggleMenu">
				<i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>

        <h3>Menu</h3>

        <div class="menu">
            <router-link to="/" class="button">
				<i class="fa-solid fa-table-columns"></i> <span class="text">Dashboard</span>
            </router-link>
			<div v-if="loggedInUser">
				<router-link to="/my-account" class="button">
					<i class="fa-solid fa-user"></i> <span class="text">My Account</span>
				</router-link>
			</div>
			<!-- <router-link to="/Profile" class="button">
				<i class="fa-solid fa-gear"></i> <span class="text">Settings</span>
			</router-link> -->
        </div>
		
        <div class="menu flex">
			<!-- <router-link to="/works" class="button">
				<i class="fa-solid fa-book-open-reader"></i> <span class="text">Works</span>
			</router-link>
			<router-link to="/bookmarks" class="button">
				<i class="fa-solid fa-bookmark"></i> <span class="text">Bookmarks</span>
			</router-link>
			<router-link to="/drafts" class="button">
				<i class="fa-regular fa-file-lines"></i> <span class="text">Drafts</span>
			</router-link>
			<router-link to="/Collections" class="button">
				<i class="fa-solid fa-layer-group"></i> <span class="text">Collections</span>
			</router-link>
			<router-link to="/Prompts" class="button">
				<i class="fa-regular fa-comment-dots"></i> <span class="text">Prompts</span>
			</router-link> -->
		</div>

        <div class="menu">
			<button class="button" type="button" @click="logout" v-if="loggedInUser">
				<i class="fa-solid fa-user"></i> <span class="text">Logout</span>
			</button>
			<router-link to="/login" class="button" v-else>
                <i class="fa-solid fa-user"></i> <span class="text">Login</span>
            </router-link>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'
import logoDefault from '@/assets/logo.svg'
import { useLogout } from '../../composables/use-logout'
import { useLoggedInUser } from '../../composables/use-logged-in-user'

const is_expanded = ref(localStorage.getItem("is_expanded") === "true")
const toggleMenu = () => {
    is_expanded.value = !is_expanded.value
    localStorage.setItem("is_expanded", is_expanded.value)
}

const logo = computed(() => {
	return logoDefault
})

const { logout } = useLogout();
const { loggedInUser } = useLoggedInUser();

</script>