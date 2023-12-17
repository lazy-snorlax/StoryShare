<template>
    <Header :title="story?.title" />

    <Container class="single-story-details" v-if="story">
        <div class="row">
            <h4>Summary</h4>
            <p>Write a brief summary of summary for this story</p>
            <text-editor v-model="story.summary" />
            <button class="col-2 btn mx-auto">Save Summary</button>
        </div>
        
        <div class="row mt-4 mb-1">
            <h4>Notes</h4>
            <p>Add any author notes for the story as a whole here.</p>
            <text-editor v-model="story.notes" />
            <button class="col-2 btn mx-auto">Save Notes</button>
        </div>

        <div class="mt-1">
            <div class="row d-flex">
                <h2 class="mt-5 text-center">Chapters</h2>
            </div>
            <div class="row">
                <div class="col mx-auto text-center">
                    <a class="btn w-100" >
                        Add New Chapter
                    </a>
                </div>
                <!-- <div class="col mx-auto text-center">
                    <a class="btn w-100">Download Story</a>
                </div>
                <div class="col mx-auto text-center">
                    <a class="btn w-100">Add to My Bookmarks</a>
                </div> -->
            </div>
            <div class="row">
                <template v-for="chapter in story?.chapters" class="col mx-auto">
                    <ChapterListItem :chapter="chapter" />
                </template>
            </div>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue';
import { useStory } from '../../composables/stories/use-get-story';
import { useRoute } from 'vue-router'
import ChapterListItem from '../../components/story/ChapterListItem.vue';
import TextEditor from '../../components/app/utilities/text-editor/TextEditor.vue'

const { story, getStory } = useStory()
const route = useRoute()

onMounted(async () => {
    await getStory(route.params.id)
})
</script>