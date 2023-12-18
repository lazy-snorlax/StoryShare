<template>

    <Header :title="chapter?.title" />

    <Container class="">
        <ChapterNav class="chapter-nav" :chapter_number="chapter?.chapter_number" :chapter_list="chapter_list" />

        <div class="my-story-content" v-if="chapter">
            <div class="my-story-content-summary mb-3" v-if="chapter.summary">
                <h3>Summary</h3>
                <text-editor v-model="chapter.summary" name="summary" />
            </div>    
            
            <div class="my-5 my-story-content-summary content">
                <text-editor v-model="chapter.content" name="content" />
            </div>
            
            <div class="my-story-content-summary mt-3">
                <h3>Notes</h3>
                <text-editor v-model="chapter.notes" name="notes" />
            </div>
        </div>
    </Container>

</template>
<script lang="ts" setup>
import { useChapter } from '../../composables/stories/use-get-chapter';
import { useChapterList } from '../../composables/stories/use-get-chapter-list';
import { useRoute } from 'vue-router';
import { onMounted, watch } from 'vue';

import TextEditor from '../../components/app/utilities/text-editor/TextEditor.vue';

import ChapterNav from '../../components/story/ChapterNav.vue';

const { chapter, getChapters } = useChapter()
const { chapter_list, getChapterList } = useChapterList()
const route = useRoute()

onMounted(async () => {
    await getChapters(route.params?.chapter)
    await getChapterList(route.params?.id)
})

watch(() => route.params.chapter, async () => {
    if (route.params.chapter) {
        await getChapters(route.params?.chapter)
    }
})

watch(() => route.params.id, async () => {
    await getChapterList(route.params?.id)
})
</script>

<style lang="scss">
.my-story-content {
    .my-story-content-summary {
        background-color: var(--light);
        color: var(--light-alt);
        border-radius: 10px;
        padding-bottom: 2rem;
        padding: 1rem;
    }

    .content {
        color: var(--white);
        .editor {
            min-height: 40rem;
            max-height: 40rem;
        }
    }
}

</style>