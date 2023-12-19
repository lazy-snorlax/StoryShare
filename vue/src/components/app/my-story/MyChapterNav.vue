<template>
    <div class="row my-3 d-flex">
        <div class="col mx-auto text-center">
            <router-link v-if="props.chapter_number == 0" class="chapter-btn btn" :to="{ name: 'my-stories.single' }">
                Return to Story Summary
            </router-link>
            <router-link v-else class="chapter-btn btn" :to="{ name: 'my-stories.chapter.all' }">
                View Entire Story
            </router-link>
        </div>
        <template v-if="props.chapter_number !== 0">
            <div class="col mx-auto text-center" v-if="props.chapter_number > 1">
                <router-link class="chapter-btn btn" :to="{ name: 'my-stories.chapter.single', params: { chapter: previous } }">
                    Previous Chapter
                </router-link>
            </div>
            <div class="col mx-auto text-center">
                <router-link class="chapter-btn btn" :to="{ name: 'my-stories.single' }">
                    Return to Story Summary
                </router-link>
            </div>
            <div class="col mx-auto text-center">
                <a class="chapter-btn btn">
                    Jump to Chapter
                </a>
            </div>
            <div class="col mx-auto text-center" v-if="props.chapter_number !== props.chapter_list?.length">
                <router-link class="chapter-btn btn" :to="{ name: 'my-stories.chapter.single', params: { chapter: next } }">
                    Next Chapter
                </router-link>
            </div>
        </template>
    </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue';
import { ChapterListResource } from '../../../stores/chapter';

const props = defineProps({
    chapter_number: Number,
    chapter_list: Array<ChapterListResource> || null
})

const previous = computed(() => {
    return props.chapter_list ? props.chapter_list[
        props.chapter_list?.map(ch => ch.chapter_number).indexOf(props.chapter_number) - 1
    ]?.id : 0
})

const next = computed(() => {
    return props.chapter_list ? props.chapter_list[
        props.chapter_list?.map(ch => ch.chapter_number).indexOf(props.chapter_number) + 1
    ]?.id : 0
})
</script>