<template>
    <div class="row my-3 d-flex">
        <!-- <div class="col mx-auto text-center">
            <a class="chapter-btn btn">
                View All Chapters
            </a>
        </div> -->
        <div class="col mx-auto text-center" v-if="props.chapter_number > 1">
            <router-link class="chapter-btn btn" :to="{ name: 'story.chapter.single', params: { chapter: props.chapter_number-1 } }">
                Previous Chapter
            </router-link>
        </div>
        <div class="col mx-auto text-center">
            <a class="chapter-btn btn">
                Jump to Chapter
            </a>
        </div>
        <div class="col mx-auto text-center" v-if="props.chapter_number !== props.number_of_chapters">
            <router-link class="chapter-btn btn" :to="{ name: 'story.chapter.single', params: { chapter: props.chapter_number+1 } }">
                Next Chapter
            </router-link>
        </div>
        <!-- <div class="col mx-auto text-center">
            <a class="chapter-btn btn">
                Comments
            </a>
        </div>
        <div class="col mx-auto text-center">
            <a class="chapter-btn btn">
                Share
            </a>
        </div>
        <div class="col mx-auto text-center">
            <a class="chapter-btn btn">
                Download
            </a>
        </div> -->
    </div>
</template>
<script lang="ts" setup>

const props = defineProps({
    chapter_number: Number,
    number_of_chapters: Number
})

</script>