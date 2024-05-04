<template>
    <li class="story blurb group" style="">
        <div class="header">
            <router-link class="story-link" :to="{ name: 'my-stories.single', params: { id: item.id } }">
                <h4 class="my-3">{{ item.title }}</h4>
            </router-link>
            <h5 class="my-3">By: {{ item.user }}</h5>
            <div class="genres">
                <span v-for="genre in item.genres">
                    {{ genre.name }} &nbsp; &nbsp;
                </span>
            </div>
            <!-- <div class="tags"></div> -->
            <div class="dates">
                <p class="datetime">Created: <span>{{ item.created_at }}</span></p>
                <p class="datetime">Updated: <span>{{ item.updated_at }}</span></p>
            </div>
        </div>
        <div class="summary" v-html="item.summary" />
        <div class="footer">
            <div class="row d-flex">
                <div class="col">
                    <p>Chapters: <span>{{ item.number_of_chapters }}</span></p>
                </div>
                <div class="col">
                    <p>Words: <span>{{ item.word_count }}</span></p>
                </div>
                <div class="col">
                    <p>Complete: 
                        <span>
                            <font-awesome-icon icon="fa-solid fa-check" v-if="item.complete" />
                            <font-awesome-icon icon="fa-solid fa-check" v-else />
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </li>
</template>
<script lang="ts" setup>

const props = defineProps({
    item: {
        title: String,
        created_at: String,
        updated_at: String,
        summary: String,
        number_of_chapters: Number,
        word_count: Number,
    }
})

</script>