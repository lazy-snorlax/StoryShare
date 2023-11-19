<template>
    <header class="page-header">
        <div class="left"></div>
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

const props = defineProps<{
    title?: string|null,
    subtitle?: string|null,
}>()

</script>