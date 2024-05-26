<template>

    <Header :title="story?.title" />

    <Container class="">
        <ChapterNav class="chapter-nav" :chapter_number="0" />

        <template v-for="chapter in all_chapters">
            <div class="story-content mb-5">
                <h3 class="text-center">{{ chapter?.title }}</h3>
                <div class="mb-3" v-if="chapter?.summary">
                    <h3>Summary</h3>
                    <p v-html=chapter?.summary></p>
                </div>    
                
                <div class="my-5 content" v-html="chapter?.content"></div>
                
                <div class="mt-3" v-if="chapter?.notes">
                    <h3>Notes</h3>
                    <p v-html=chapter.notes></p>
                </div>
            </div>
        </template>

        <!-- Comments -->
    </Container>

</template>
<script lang="ts" setup>
import { useAllChapters } from '../../composables/stories/use-get-all-chapters';
import { useStory } from '../../composables/stories/use-get-story';
import { useRoute } from 'vue-router';
import { onMounted, watch } from 'vue';
import ChapterNav from '../../components/story/ChapterNav.vue';

const { all_chapters, getAllChapters } = useAllChapters()
const { story, getStory } = useStory()
const route = useRoute()

onMounted(async () => {
    await getAllChapters(route.params?.id)
    await getStory(route.params?.id)
})

watch(() => route.params.id, async () => {
    await getAllChapters(route.params?.id)
    await getStory(route.params?.id)
})
</script>