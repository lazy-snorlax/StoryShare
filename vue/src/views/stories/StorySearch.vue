<template>
    <Header :title="'Search'" />

    <div class="d-flex">
        <Container class="container-max-xxl mx-auto p-4 d-flex">
            
            <div class="story-list">
                <template v-for="item in list">
                    <StoryListItem :item="item" />
                </template>
            </div>    
        </Container>
        
        <div class="sidesheet">
            <!-- Story Search filters -->
            <StorySearchFilters :filters="filters"  />
        </div>
    </div>

</template>
<script lang="ts" setup>
import { useStoryStore, getStoryList } from '@/stores/story';
import StoryListItem from '@/components/story/StoryListItem.vue';
import StorySearchFilters from './StorySearchFilters.vue';
import { useStoryList } from '@/composables/stories/use-get-story-list';
import { onMounted, ref, watchEffect } from 'vue';

const { getStoryList } = useStoryStore()
const { list } = useStoryList()
const filters = ref({
    search: null,
    sort: 'updated_at'
})

onMounted(async () => {
    await getStoryList()
})

watchEffect(async () => {
    if (filters.value.search == null) return
    await getStoryList(new URLSearchParams(filters.value))
})

</script>