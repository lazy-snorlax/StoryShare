<template>
    <div id="latest-page_sub-nav">
        <div id="sub-nav_inner" class="disabled">
            <div class="sub-nav_paging" style="opacity: 1;">
                <a class="nav_prev disabled" href="##" rel="ajax">
                    <i class="fas fa-angle-left"></i>
                    <span>Prev</span>
                </a>
                <div class="sub-nav_info-paging_nums">
                    <a class="btn-small current" data-page="1">1</a>
                </div>
                <a class="nav_next" href="#/cat=games/page=2" rel="ajax">
                    <span>Next</span>
                    <i class="fas fa-angle-right"></i>
                </a>
            </div>
            <div id="sub-nav_controls">
                <div class="controls-block">
                    <a id="controls_auto-refresh" data-tooltip="Auto Refresh" class="">
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
import { defineEmits, watch, ref } from 'vue'

const emit = defineEmits(['toggleFilter'])

</script>