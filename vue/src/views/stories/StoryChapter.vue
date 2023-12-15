<template>

    <Header :title="chapter?.title" />

    <Container class="">
        <ChapterNav class="chapter-nav" :chapter_number="chapter?.chapter_number" :number_of_chapters="chapter?.story?.number_of_chapters" />

        <div class="story-content">
            <div class="mb-3" v-if="chapter?.summary">
                <h3>Summary</h3>
                <p>{{ chapter?.summary }}</p>
            </div>    
            
            <div class="my-5 content">
                {{ chapter?.content }}
            </div>
            
            <div class="mt-3" v-if="chapter?.notes">
                <h3>Notes</h3>
                <p>{{ chapter.notes }}</p>
            </div>
        </div>
    </Container>

</template>
<script lang="ts" setup>
import { useChapter } from '../../composables/stories/use-get-chapter';
import { useRoute } from 'vue-router';
import { onMounted } from 'vue';
import ChapterNav from '../../components/story/ChapterNav.vue';

const { chapter, getChapters } = useChapter()
const route = useRoute()

onMounted(async () => {
    await getChapters(route.params?.chapter)
})

</script>