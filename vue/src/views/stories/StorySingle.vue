<template>
    <Header :title="story?.title" />

    <Container class="card bg-dark text-light">
        <h3>Story Details</h3>
        <h5>Summary</h5>
        <p>{{ story?.summary }}</p>
        
        <h5>Notes</h5>
        <p>{{ story?.notes }}</p>

        <div class="mt-5">
            <h2>Chapter Index:</h2>
            <template v-for="chapter in story?.chapters">
                <ChapterListItem :chapter="chapter" />
            </template>
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