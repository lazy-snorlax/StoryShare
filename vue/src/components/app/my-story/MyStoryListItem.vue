<template>
    <li class="story blurb group" style="">
        <div class="header">
            <router-link class="story-link" :to="{ name: 'my-stories.single', params: { id: item.id } }">
                <h4 class="my-3">{{ item.title }}</h4>
            </router-link>
            <div class="d-flex my-3">
                <div class="rating me-3" :class="`${ item.rating.toLowerCase().replace(' ', '-') }`" @click="open">{{ item.rating[0] }}</div>
                <h5 class="">By: {{ item.user }}</h5>
            </div>
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
                    <p>Chapters: <span> {{ item.completed_number_of_chapters }} / {{ item.total_number_of_chapters > 0 ?  item.total_number_of_chapters : '?' }}</span></p>
                </div>
                <div class="col">
                    <p>Words: <span>{{ item.word_count }}</span></p>
                </div>
                <div class="col">
                    <p>Complete: 
                        <span>
                            <font-awesome-icon icon="fa-solid fa-check" v-if="item.complete" />
                            <font-awesome-icon icon="fa-solid fa-xmark" v-else />
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </li>
</template>
<script lang="ts" setup>
import { useModal } from 'vue-final-modal'
import ModalRatings from '../ModalRatings.vue';

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

const { open, close } = useModal({
	component: ModalRatings
})

</script>