<template>
    <Header :title="story?.title" />

    <Container class="single-story-details">
        <div class="row">
            <h4>Summary</h4>
            <p>{{ story?.summary }}</p>
        </div>
        
        <div class="row mt-4 mb-1">
            <h4>Notes</h4>
            <p>{{ story?.notes }}</p>
        </div>

        <div class="mt-1">
            <div class="row d-flex">
                <h2 class="mt-5 text-center">Chapters</h2>
            </div>
            <div class="row">
                <!-- <div class="col mx-auto text-center">
                    <router-link :to="{ name: 'story.chapter' }" class="btn">
                        <h5>View All Chapters</h5>
                    </router-link>
                </div> -->
                <template v-for="chapter in story?.chapters" class="col mx-auto">
                    <ChapterListItem :chapter="chapter" />
                </template>
            </div>
            <!-- <div class="row">
            </div> -->
        </div>
    </Container>
</template>
<script lang="ts" setup>
import { onMounted } from 'vue';
import { useStory } from '../../composables/stories/use-get-story';
import { useRoute } from 'vue-router'
import ChapterListItem from '../../components/story/ChapterListItem.vue';

const { story, getStory } = useStory()
const route = useRoute()

onMounted(async () => {
    await getStory(route.params.id)
})


</script>