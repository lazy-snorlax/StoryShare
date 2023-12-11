<template>
    <Header :title="'Search'" />

    <Container class="container-max-xl mx-auto p-4">
        <template v-for="item in list">
            <StoryListItem :item="item" />
        </template>
    </Container>
</template>
<script lang="ts" setup>
import { useStoryStore } from '../../stores/story';
import StoryListItem from '../../components/story/StoryListItem.vue';
import { useStoryList } from '../../composables/stories/use-get-story-list';
import { onMounted } from 'vue';

const { getStoryList } = useStoryStore()
const { list } = useStoryList()

onMounted(async () => {
    await getStoryList()
})

</script>