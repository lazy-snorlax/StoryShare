<template>
    <router-link :to="{ name: 'story.chapter.single', params: { chapter: chapter.id } }" class="chapter-item">
        <li>
            <h5>{{ chapter.title }}</h5>
            <p v-html="chapter.summary"></p>
            <div class="mt-3 row d-flex">
                <div class="col">
                    <small>Updated: {{ chapter.updated_at }}</small>
                </div>
                <div class="col">
                    <small>Word Count: {{ chapter.word_count }}</small>
                </div>
                <div class="col">
                    <small>Comments: {{ chapter.comment_count }}</small>
                </div>
            </div>
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