<template>
    <Header :title="'My Stories'" />
    
    <Container class="container-max-xl mx-auto p-4" >
        <div v-for="item in list">
            <StoryListItem :item="item" />
        </div>
    </Container>
</template>
<script lang="ts" setup>
import { useMyStoryStore } from '../../stores/my-story';
import { onMounted } from 'vue';
import { useMyStoryList } from '../../composables/stories/use-get-my-story-list';
import StoryListItem from '../../components/story/StoryListItem.vue';

const myStoryStore = useMyStoryStore()
const { list } = useMyStoryList()

onMounted(async () => {
    await myStoryStore.getMyStoryList()
})

</script>
