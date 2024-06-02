<template>
    <Header :title="'My Bookmarks'" />

    <div class="d-flex">
        <Container class="m-auto p-4 d-flex flex-column" style="width: -moz-available;">
            
            <div class="d-inline-flex w-100">
                <StorySearchSubNav :pagination="results.pagination" @toggleFilter="toggleFilters" @triggerReload="reloadStoryList" @pagePrevious="previous" @pageNext="next" @pageJump="pageJump"/>
            </div>
            
            <div class="d-inline-flex">
                <div class="story-list w-100">
                    <template v-for="item in results.list">
                        <StoryListItem :item="item.story" />
                    </template>
                </div>
                <!-- Story Search filters -->
                <StorySearchFilters :filters="filters" :resultNumber="results.pagination.total" />
            </div>
        </Container>
    </div>
</template>
<script setup lang="ts">
import { onMounted, ref, watchEffect, watch, computed } from 'vue'
import { storeToRefs } from 'pinia'

import { useAuthStore } from '@/stores/auth'
import { useMyBookmarkStore } from '@/stores/my-bookmarks'

import StoryListItem from '@/components/story/StoryListItem.vue'
import StorySearchFilters from '@/components/search/StorySearchFilters.vue'
import StorySearchSubNav from '@/components/search/StorySearchSubNav.vue'

import useMyBookmarkList from '@/composables/use-get-my-bookmark-list'

const { toggleFilters } = useAuthStore()
const { getMyBookmarkList } = useMyBookmarkStore()
const { results } = useMyBookmarkList()
const filters = ref({
    search: null,
    author: null,
    sort: 'updated_at',
    genre: [],
    tags: [],
})

watch(filters.value, () => { reloadStoryList() })

onMounted(async () => {
    reloadStoryList()
})

const reloadStoryList = async () => {
    await getMyBookmarkList(filters.value)
}

// Pagination Controls
const pageJump = async (page = 1) => {
    await getMyBookmarkList(filters.value, page)
}
const next = async () => {
    await getMyBookmarkList(filters.value, results.value.pagination?.current_page < results.value.pagination?.last_page ? results.value.pagination?.current_page + 1 : results.value.pagination?.current_page)
}
const previous = async () => {
    await getMyBookmarkList(filters.value, results.value.pagination.current_page > 1 ? results.value.pagination.current_page - 1 : 1)
}

</script>