<template>
    <aside id="filter-sidebar-wrapper" :class="`${toggleSearchFilters ? '' : 'hide-filters'}`">
        <div class="content">
            <h3 class="content-filter-title">
                <div id="filter-title">
                    <i class="fas fa-filter"></i>
                    Filters
                </div>
                <div id="filter-controls">
                    <a class="btn btn-small" @click="clearFilters"><i class="fas fa-undo-alt"></i></a>
                </div>
            </h3>
            <div class="filter-block">
                <h4 class="filter-block-title">Search</h4>
                <div class="filter-block-content">
                    <input type="text" name="search" class="form-control" v-model="query">
                </div>
            </div>
            <div class="filter-block">
                <h4 class="filter-block-title">Author</h4>
                <div class="filter-block-content">
                    <input type="text" name="search" class="form-control" v-model="queryAuthor">
                </div>
            </div>
            <div class="filter-block">
                <h4 class="filter-block-title">Sort By</h4>
                <div class="filter-block-content">
                    <MultiSelect v-model="filters.sort" :options="sortByOptions" value-only />
                </div>
            </div>
            <div class="filter-block">
                <h4 class="filter-block-title">Ratings</h4>
                <div class="filter-block-content">
                    <MultiSelect v-model="filters.rating" :options="ratingList" :allow-empty="true" :trackBy="'id'" :label="'name'" :no-searching="true" :multiple="true" />
                </div>
            </div>
            <div class="filter-block">
                <h4 class="filter-block-title">Genre</h4>
                <div class="filter-block-content">
                    <MultiSelect v-model="filters.genre" :options="genreList" :allow-empty="true" :trackBy="'id'" :label="'name'" :no-searching="true" :multiple="true" />
                </div>
            </div>
            <div class="filter-block">
                <h4 class="filter-block-title">Story Tags</h4>
                <div class="filter-block-content">
                    <MultiSelect v-model="filters.tag" :options="[]" :allow-empty="true" :trackBy="'id'" :label="'name'" :no-searching="true" :multiple="true" />
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="info-count">
                <i class="fas fa-info-circle"></i>
                <span class="ms-3">{{ resultNumber }} Results</span>
            </div>
        </div>
    </aside>

</template>

<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, toRefs, watch, watchEffect, defineProps } from 'vue';
import MultiSelect from '@/components/app/utilities/MultiSelect.vue';

import { useAuthStore } from '@/stores/auth'
import { useGenreStore } from '@/stores/genres'
import { useRatingStore } from '@/stores/ratings';

import debouncedRef from '../../composables/debouceRef';

const props = defineProps<{
        filters?: {
            search: string,
            author: string,
            sort: string,
            rating: array,
            genre: array,
            tag: array,
        },
        resultNumber?: Number
    }>()

const filters = ref(props.filters);

const query = debouncedRef(filters.value?.search, 400)
const queryAuthor = debouncedRef(filters.value?.author, 400)

const is_filter_expanded = ref(localStorage.getItem("is_filter_expanded") === "true")
const toggleMenu = () => {
    is_filter_expanded.value = !is_filter_expanded.value
    localStorage.setItem("is_filter_expanded", is_filter_expanded.value)
}

const sortByOptions = [
    { label: 'Title A-Z', value: 'title' },
    { label: 'Title Z-A', value: '-title' },
    { label: 'Last Updated', value: 'updated_at' },
    { label: 'First Created', value: 'created_at' },
]

const genreStore = useGenreStore()
const { genreList } = storeToRefs(genreStore)
genreStore.getGenreList()

const ratingStore = useRatingStore()
const { ratingList } = storeToRefs(ratingStore)
ratingStore.getRatingList()

const emit = defineEmits<{
    updateFilters: [filters: {}]
}>()

onMounted(() => {
  emit('updateFilters', filters)
})

watch(query, newQuery => {
    filters.value.search = newQuery
    emit('updateFilters', filters)
})
watch(queryAuthor, newQueryAuthor => {
    filters.value.author = newQueryAuthor
    emit('updateFilters', filters)
})

const authStore = useAuthStore()
const { toggleSearchFilters } = storeToRefs(authStore)

const clearFilters = () => {
    query.value = ''
    queryAuthor.value = ''

    filters.value.search = ''
    filters.value.author = ''
    filters.value.sort = 'updated_at'
    filters.value.genre = null
    filters.value.rating = null
}

</script>