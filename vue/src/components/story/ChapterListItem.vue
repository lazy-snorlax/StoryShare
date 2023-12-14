<template>
    <li class="chapter-item">
        <h3>{{ chapter.title }}</h3>
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