<template>
    <router-link :to="{ name: 'story.chapter.single', params: { chapter: chapter.id } }" class="chapter-item">
        <li>
            <h5>{{ chapter.title }}</h5>
            <p v-html="chapter.summary"></p>
            <small>Updated: {{ chapter.updated_at }}</small>
        </li>
    </router-link>
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