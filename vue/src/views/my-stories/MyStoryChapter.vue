<template>

    <Header :title="chapter?.title" />

    <Container class="">
        <MyChapterNav class="chapter-nav" :chapter_number="chapter?.chapter_number" :chapter_list="chapter_list" />

        <div class="my-story-content" v-if="chapter">
            <div class="my-story-content-summary mb-3 d-flex">
                <h3>Chapter Title</h3>
                <div class="col-8 ms-auto">
                    <input type="text" v-model="chapter.title" class="form-control">
                </div>
            </div>
            <div class="my-story-content-summary mb-3 d-flex">
                <h3>Chapter Number</h3>
                <div class="col-8 ms-auto">
                    <input type="number" v-model="chapter.chapter_number" class="form-control">
                </div>
            </div>

            <div class="my-story-content-summary mb-3">
                <h3>Summary</h3>
                <text-editor v-model="chapter.summary" name="summary" />
            </div>
            
            <div class="my-3 my-story-content-summary content">
                <text-editor v-model="chapter.content" @words="setWordCount" name="content" />
                <div class="row">
                    <div class="col-3 mx-auto">
                        <button class="btn w-100" @click="saveChapter">Save</button>
                    </div>
                </div>
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
import { onMounted, watch, ref, reactive } from 'vue';

import TextEditor from '../../components/app/utilities/text-editor/TextEditor.vue';
import MyChapterNav from '../../components/app/my-story/MyChapterNav.vue';
import { useChapterStore, type ChapterResource } from '../../stores/chapter';

const { chapter, getChapters } = useChapter()
const { chapter_list, getChapterList } = useChapterList()
const route = useRoute()
const { updateMyChapter } = useChapterStore()

const wordCount = reactive(ref())

onMounted(async () => {
    await getChapters(route.params?.chapter)
    await getChapterList(route.params?.id)
})

function setWordCount(words) {
    wordCount.value = words
}

watch(() => route.params.chapter, async () => {
    if (route.params.chapter) {
        await getChapters(route.params?.chapter)
    }
})

watch(() => route.params.id, async () => {
    await getChapterList(route.params?.id)
})

const saveChapter = async () => {
    const values = <ChapterResource>{
        id: chapter.value.id,
        chapter_number: chapter.value.chapter_number,
        title: chapter.value.title,
        summary: chapter.value.summary,
        content: chapter.value.content,
        notes: chapter.value.notes,
        word_count: wordCount.value,
    }

    await updateMyChapter(values)
}
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

    .form-control {
        color: var(--white);
        background-color: var(--dark-alt);
        border: none;
        &:focus {
            color: var(--white);
            background-color: var(--dark-alt);
        }
    }

    .btn {
        color: var(--dark-alt);
        background-color: var(--light-alt);
        &:hover{
            background-color: var(--dark-alt);
            color: var(--light-alt);
        }
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