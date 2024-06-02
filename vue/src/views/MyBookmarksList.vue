<template>
    <Header :title="'My Bookmarks'" />

    <div class="d-flex">
        <Container class="m-auto p-4 d-flex flex-column" style="width: -moz-available;">
            
            <div class="d-inline-flex w-100"></div>
            
            <!-- <div class="d-inline-flex">
                <div class="story-list w-100">
                    <template v-for="item in results.list">
                        <StoryListItem :item="item" />
                    </template>
                </div>
                <StorySearchFilters :filters="filters" :resultNumber="results.pagination.total" />
            </div> -->
        </Container>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'

import StoryListItem from '@/components/story/StoryListItem.vue'
import StorySearchFilters from '@/components/search/StorySearchFilters.vue'
import StorySearchSubNav from '@/components/search/StorySearchSubNav.vue'

const filters = ref({
    search: null,
    author: null,
    sort: 'updated_at',
    genre: [],
    tags: [],
})

</script>