<template>
    <Header :title="'My Stories'" />
    
    <Container class="container-max-xl mx-auto p-4" >
        <div class="chapter-nav">
            <div class="row my-3 d-flex">
                <div class="col mx-auto text-center">
                    <a class="chapter-btn btn">Create New Story</a>
                </div>
            </div>
        </div>

        <div v-for="item in list">
            <MyStoryListItem :item="item" />
        </div>
    </Container>
</template>
<script lang="ts" setup>
import { useMyStoryStore } from '../../stores/my-story';
import { onMounted } from 'vue';
import { useMyStoryList } from '../../composables/stories/use-get-my-story-list';
import MyStoryListItem from '../../components/app/my-story/MyStoryListItem.vue';

const myStoryStore = useMyStoryStore()
const { list } = useMyStoryList()

onMounted(async () => {
    await myStoryStore.getMyStoryList()
})

</script>
