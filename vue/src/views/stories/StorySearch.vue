<template>
    <Header :title="'Browse'" />

    <div class="d-flex">
        <Container class="m-auto p-4 d-flex flex-column" style="width: -moz-available;">            
            
            <div class="d-inline-flex w-100">
                <StorySearchSubNav :pagination="results.pagination" @toggleFilter="toggleFilters" @triggerReload="reloadStoryList" @pagePrevious="previous" @pageNext="next" @pageJump="pageJump"/>
            </div>

            <div class="d-inline-flex">
                <div class="story-list w-100">
                    <template v-for="item in results.list">
                        <StoryListItem :item="item" />
                    </template>
                </div>
                <!-- Story Search filters -->
                <StorySearchFilters :filters="filters" :resultNumber="results.pagination.total" />
            </div>

        </Container>
        
    </div>

</template>
<script lang="ts" setup>
import { useStoryStore, getStoryList } from '@/stores/story';
import StoryListItem from '@/components/story/StoryListItem.vue';

import StorySearchFilters from '../../components/search/StorySearchFilters.vue';
import StorySearchSubNav from '../../components/search/StorySearchSubNav.vue';

import { useStoryList } from '@/composables/stories/use-get-story-list';
import { onMounted, ref, watchEffect, watch, computed } from 'vue';

import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'

const { getStoryList } = useStoryStore()
const { results } = useStoryList()
const filters = ref({
    search: null,
    author: null,
    sort: 'updated_at',
    genre: [],
    tags: [],
})

onMounted(async () => {
    reloadStoryList()
})

watch(
    filters.value,
    () => {
        console.log('Filters: ', filters.value)
        reloadStoryList()
    }
)

const reloadStoryList = async () => {
    await getStoryList(filters.value)
}

const pageJump = async (page = 1) => {
    await getStoryList(filters.value, page)
}

const next = async () => {
    await getStoryList(filters.value, results.value.pagination?.current_page < results.value.pagination?.last_page ? results.value.pagination?.current_page + 1 : results.value.pagination?.current_page)
}

const previous = async () => {
    await getStoryList(filters.value, results.value.pagination.current_page > 1 ? results.value.pagination.current_page - 1 : 1)
}

const { toggleFilters } = useAuthStore()

</script>