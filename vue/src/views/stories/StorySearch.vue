<template>
    <Header :title="'Browse'" />

    <div class="d-flex">
        <Container class="m-auto p-4 d-flex flex-column" style="width: -moz-available;">            
            
            <div class="d-inline-flex w-100">
                <StorySubNav @toggleFilter="toggleFilters" />
            </div>

            <div class="d-inline-flex">
                <div class="story-list w-100">
                    <template v-for="item in list">
                        <StoryListItem :item="item" />
                    </template>
                </div>    
                <!-- Story Search filters -->
                <StorySearchFilters :filters="filters" />
            </div>

        </Container>
        
    </div>

</template>
<script lang="ts" setup>
import { useStoryStore, getStoryList } from '@/stores/story';
import StoryListItem from '@/components/story/StoryListItem.vue';
import StorySearchFilters from './StorySearchFilters.vue';
import StorySubNav from './StorySubNav.vue';
import { useStoryList } from '@/composables/stories/use-get-story-list';
import { onMounted, ref, watchEffect } from 'vue';

import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'

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

const { toggleFilters } = useAuthStore()

</script>