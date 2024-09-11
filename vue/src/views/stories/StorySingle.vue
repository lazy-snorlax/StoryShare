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

        <div class="row mt-1 d-flex">
            <div class="col">
                <p>Chapters: <span>{{ story?.number_of_chapters }}</span></p>
            </div>
            <div class="col">
                <p>Words: <span>{{ story?.word_count }}</span></p>
            </div>
            <div v-if="story?.applause > 0" class="col">
                <p>Applause: <span>{{ story?.applause }}</span></p>
            </div>
            <div class="col">
                <p>Completed: 
                    <span>
                        <font-awesome-icon icon="fa-solid fa-check" v-if="story?.complete" />
                        <font-awesome-icon icon="fa-solid fa-check" v-else />
                    </span>
                </p>
            </div>
        </div>

        <div class="row mt-1 d-flex align-items-baseline">
            <div class="col mx-auto text-center">
                <router-link class="btn w-100" :to="{ name: 'story.chapter.all' }">
                    View Entire Story
                </router-link>
            </div>
            <div class="col mx-auto text-center">
                <a v-if="story?.bookmark" class="btn w-100" @click="removeBookmark"> <i class="fa-solid fa-bookmark"></i> Bookmarked</a>
                <a v-else class="btn w-100" @click="createNewBookmark"> <i class="fa-solid fa-bookmark"></i> Bookmark</a>
            </div>
            <div class="col mx-auto text-center">
                <a class="btn w-100" @click="applaude"> <i class="fa-solid fa-hands-clapping"></i> Applaude</a>
            </div>
            <!-- <div class="col mx-auto text-center">
                <a class="btn w-100">Download Story</a>
            </div> -->
        </div>

        <div class="mt-1">
            <h2 class="col mt-5 text-left">Chapters</h2>
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
import { useApplauseStore } from '@/stores/applause'
import { useAuthStore } from '@/stores/auth'

import ChapterListItem from '@/components/story/ChapterListItem.vue';

import { useLoggedInUser } from '../../composables/use-logged-in-user';
import { useStory } from '@/composables/stories/use-get-story';


const { newBookmark, deleteBookmark } = useMyBookmarkStore()
const { applaudeStory } = useApplauseStore()
const { getClientIpAddress } = useAuthStore()

const { loggedInUser } = useLoggedInUser()
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

const applaude = async () => {
    if (loggedInUser) {
        // Applaude story using user_id
        await applaudeStory(route.params.id) 
    } else {
        // Get client ip_address
        const ip_address = 'localhost' // await getClientIpAddress()

        // console.log('>>> IP Address: ', ip_address)
        if (ip_address != null) {    
            // Applaude story using client ip_address
            await applaudeStory(route.params.id, ip_address)
        }
    }
}

</script>