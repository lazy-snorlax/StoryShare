<template>
    <div id="filter-sidebar-wrapper" :class="`${ is_filter_expanded ? 'is-filter-expanded' : '' }`" >
        <div class="menu-toggle-wrap">
            <button class="menu-toggle" @click="toggleMenu">
                <font-awesome-icon icon="fa-solid fa-filter"></font-awesome-icon>
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
    </div>
</template>

<script lang="ts" setup>
import { onMounted, ref, toRefs, watch, watchEffect } from 'vue';
import MultiSelect from '../../components/app/utilities/MultiSelect.vue';
import { defineProps } from 'vue';

const props = defineProps<{
        filters?: {
            search: string | null,
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
    }
)

</script>