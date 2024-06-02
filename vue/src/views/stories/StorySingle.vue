<template>
    <Header :title="story?.title" />

    <Container class="single-story-details">
        <div class="row">
            <h4>Summary</h4>
            <div v-html="story?.summary" />
        </div>
        
        <div class="row mt-4 mb-1">
            <h4>Notes</h4>
            <div v-html="story?.notes" />
        </div>

        <div class="mt-1">
            <div class="row d-flex align-items-baseline">
                <h2 class="col mt-5 text-left">Chapters</h2>
                <div class="col mx-auto text-center">
                    <router-link class="btn w-100" :to="{ name: 'story.chapter.all' }">
                        View Entire Story
                    </router-link>
                </div>
                <div class="col mx-auto text-center">
                    <a v-if="story?.bookmark" class="btn w-100" @click="removeBookmark">Remove from My Bookmarks</a>
                    <a v-else class="btn w-100" @click="createNewBookmark">Add to My Bookmarks</a>
                </div>
                <!-- <div class="col mx-auto text-center">
                    <a class="btn w-100">Download Story</a>
                </div> -->
            </div>
            <div class="row"></div>
            <div class="row">
                <template v-for="chapter in story?.chapters" class="col mx-auto">
                    <ChapterListItem :chapter="chapter" />
                </template>
            </div>
        </div>
    </Container>
</template>
<script lang="ts" setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router'
import { useMyBookmarkStore } from '@/stores/my-bookmarks'

import ChapterListItem from '@/components/story/ChapterListItem.vue';

import { useStory } from '@/composables/stories/use-get-story';

const { newBookmark, deleteBookmark } = useMyBookmarkStore()

const { story, getStory } = useStory()
const route = useRoute()

onMounted(async () => {
    await getStory(route.params.id)
})

const createNewBookmark = async () => {
    await newBookmark({ story_id: story.value.id })
    await getStory(route.params.id)
}

const removeBookmark = async () => {
    // console.log('>>> Remove bookmark: ', story.value.bookmark.id)
    await deleteBookmark(story.value.bookmark.id)
    await getStory(route.params.id)
}

</script>