<template>
    <!-- <div id="filter-sidebar-wrapper" :class="`${ is_filter_expanded ? 'is-filter-expanded' : '' }`" >
        <div class="menu-toggle-wrap">
            <button class="menu-toggle" @click="toggleMenu">
                <i class="fa-solid fa-filter"></i>
            </button>
        </div>
        <h3>Filter Stories</h3>
        <div class="menu">
            <div class="filter-item">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" v-model="filters.search">
            </div>

            <div class="filter-item">
                <label class="form-label">Sort By</label>
                <MultiSelect v-model="filters.sort" :options="sortByOptions" value-only />
            </div>
        </div>
    </div> -->

    <aside id="filter-sidebar-wrapper" :class="`${toggleSearchFilters ? '' : 'hide-filters'}`">
        <div class="content">
            <h3 class="content-filter-title">
                <div id="filter-title">
                    <i class="fas fa-filter"></i>
                    Filters
                </div>
                <div id="filter-controls">
                    <a class="btn btn-small">
                        <i class="fas fa-undo-alt"></i>
                    </a>
                    <a class="btn btn-small">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </h3>
            <div class="filter-block">
                <h4 class="filter-block-title">Search</h4>
                <div class="filter-block-content">
                    <input type="text" name="search" class="form-control" v-model="filters.search">
                </div>
            </div>
            <div class="filter-block">
                <h4 class="filter-block-title">Sort By</h4>
                <div class="filter-block-content">
                    <MultiSelect v-model="filters.sort" :options="sortByOptions" value-only />
                    <!-- <div class="filter-btn-wrapper">
                        <a href class="btn btn-small" data-sort="date">
                            <i class="fas fa-clock"></i>
                        </a>
                    </div>
                    <div class="filter-btn-wrapper">
                        <a href class="btn btn-small" data-sort="likes">
                            <i class="fas fa-thumbs-up"></i>
                        </a>
                    </div>
                    <div class="filter-btn-wrapper">
                        <a href class="btn btn-small" data-sort="views">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    <div class="filter-btn-wrapper">
                        <a href class="btn btn-small" data-sort="name">
                            <i class="fas fa-sort-alpha-down"></i>
                        </a>
                    </div>
                    <div class="filter-btn-wrapper">
                        <a href class="btn btn-small" data-sort="rating">
                            <i class="fas fa-star"></i>
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="footer"></div>
    </aside>

</template>

<script lang="ts" setup>
import { onMounted, ref, toRefs, watch, watchEffect } from 'vue';
import MultiSelect from '../../components/app/utilities/MultiSelect.vue';
import { defineProps } from 'vue';

import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'

const props = defineProps<{
        filters?: {
            search: string,
            sort: string,
        }
    }>()

const filters = ref(props.filters);

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

const emit = defineEmits<{
    updateFilters: [filters: {}]
}>()

onMounted(() => {
  emit('updateFilters', filters)
})

watchEffect(() => {
    emit('updateFilters', filters)
})

const authStore = useAuthStore()
const { toggleSearchFilters } = storeToRefs(authStore)

</script>