<template>
    <header class="page-header">
        <div class="left">
            <div class="menu-toggle-wrap">
                <button class="menu-toggle" @click="toggleSidebar">
                    <font-awesome-icon icon="fa-solid fa-bars"></font-awesome-icon>
                </button>
            </div>
        </div>
        <div class="middle">
            <div class="page-title mx-3 my-3 text-center">
                <h1>{{ title }}</h1>
                <p v-if="subtitle" class="subheading">{{ subtitle }}</p>
            </div>
        </div>
        <div class="right"></div>
    </header>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'

const props = defineProps<{
    title?: string|null,
    subtitle?: string|null,
}>()

const { toggleSidebar } = useAuthStore()

</script>