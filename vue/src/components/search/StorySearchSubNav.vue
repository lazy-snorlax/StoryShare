<template>
    <div id="latest-page_sub-nav">
        <div id="sub-nav_inner" class="disabled">
            <div class="sub-nav_paging" style="opacity: 1;">
                <a class="nav_prev" :class="pagination.current_page == 1 ? 'disabled' : ''" @click="emit('pagePrevious')">
                    <i class="fas fa-angle-left"></i>
                    <span>Prev</span>
                </a>
                <div class="sub-nav_info-paging_nums">
                    <template v-for="link in pagination.links">
                        <a v-if="!isNaN(Number (link.label))" class="btn-small current" :class="pagination.current_page == link.label ? 'disabled' : ''" data-page="{{ link.label }}" @click="emit('pageJump', link.label)">{{ link.label }}</a>
                    </template>
                </div>
                <a class="nav_next" :class="pagination.current_page == pagination.last_page ? 'disabled' : ''" @click="emit('pageNext')">
                    <span>Next</span>
                    <i class="fas fa-angle-right"></i>
                </a>
            </div>
            <div id="sub-nav_controls">
                <div class="controls-block">
                    <a id="controls_auto-refresh" data-tooltip="Auto Refresh" class="" @click="emit('triggerReload')">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
                <div class="controls-block">
                    <a id="controls_toggle-options-panel" data-tooltip="Options" class="">
                        <i class="fas fa-cog"></i>
                    </a>
                </div>
                <div class="controls-block">
                    <a id="controls_filter-toggle" data-tooltip="Filters" class="" @click="emit('toggleFilter')">
                        <i class="fas fa-filter"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, defineEmits, watch, computed, ref } from 'vue'

const props = defineProps<{
    pagination: {
        current_page?: Number,
        last_page?: Number,
        per_page?: Number,
        total?: Number,
        from?: Number,
        to?: Number,
        links?: Array,
    }
}>()


const emit = defineEmits(['toggleFilter', 'triggerReload', 'pageNext', 'pagePrevious', 'pageJump'])

</script>