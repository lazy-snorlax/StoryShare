<template>
    <li class="chapter-item">
        <router-link :to="{ name: 'story.chapter.single', params: { chapter: chapter.id } }">
            <h3>{{ chapter.title }}</h3>
        </router-link>
        <p>{{ chapter.summary }}</p>
        <p>{{ chapter.updated_at }}</p>
    </li>
</template>
<script lang="ts" setup>

const props = defineProps({
    chapter: {
        id: Number,
        chapter_number: Number,
        title: String,
        summary: String,
        updated_at: String
    }
})

</script>