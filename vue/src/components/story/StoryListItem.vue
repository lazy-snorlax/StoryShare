<template>
    <li class="story blurb group" style="">
        <div class="header">
            <router-link v-if="props.my_story" class="story-link" :to="{ name: 'my-stories.single', params: { id: item.id } }">
                <h4 class="my-3">{{ item.title }}</h4>
            </router-link>
            <router-link v-else class="story-link" target="_blank" :to="{ name: 'story.single', params: { id: item.id } }">
                <h4 class="my-3">{{ item.title }}</h4>
            </router-link>

            <router-link class="story-link d-flex" :to="{ name: 'profile', params: { id: item.user_id } }">
                <div class="avatar-border">
                    <Avatar :name="item.user" :imgSrc="imgPath(item.imgSrc)" :imgSize="60" />
                </div>
                <p class="my-auto ms-2">{{ item.user }}</p>
            </router-link>

            <div class="d-flex my-3">
                <div class="rating me-3 my-auto" :class="`${ item.rating.toLowerCase().replace(' ', '-') }`" @click="open">{{ item.rating[0] }}</div>
                <div class="genres my-auto">
                    <span v-for="genre in item.genres">
                        {{ genre.name }}
                    </span>
                </div>
            </div>
            <!-- <div class="tags"></div> -->
            <div class="dates">
                <span class="datetime">Created: <span>{{ item.created_at }}</span></span>
                <span class="datetime">Updated: <span>{{ item.updated_at }}</span></span>
            </div>
        </div>
        <div class="summary" v-html="item.summary"></div>
        <div class="footer">
            <div class="mt-3 row d-flex">
                <div class="col">
                    <p>Chapters: <span> {{ item.completed_number_of_chapters }} / {{ item.total_number_of_chapters > 0 ?  item.total_number_of_chapters : '?' }}</span></p>
                </div>
                <div class="col">
                    <p>Words: <span>{{ item.word_count }}</span></p>
                </div>
                <div class="col">
                    <p>Completed: 
                        <span>
                            <font-awesome-icon icon="fa-solid fa-check" v-if="item.complete" />
                            <font-awesome-icon icon="fa-solid fa-xmark" v-else />
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="stats">
            <div class="icon-group">
                <span class="icon"><font-awesome-icon icon="fa-solid fa-eye" /></span>
                <span class="stat">{{ item.view_count }}</span>
            </div>
            <div class="icon-group">
                <span class="icon"><font-awesome-icon icon="fa-solid fa-hands-clapping" /></span>
                <span class="stat">{{ item.applause_count }}</span>
            </div>
            <div class="icon-group">
                <span class="icon"><font-awesome-icon icon="fa-solid fa-bookmark" /></span>
                <span class="stat">{{ item.bookmark_count }}</span>
            </div>
            <div class="icon-group">
                <span class="icon"><font-awesome-icon icon="fa-solid fa-comment" /></span>
                <span class="stat">{{ item.comment_count }}</span>
            </div>
        </div>
    </li>
</template>
<script lang="ts" setup>
import { useModal } from 'vue-final-modal'
import ModalRatings from '../app/ModalRatings.vue';

import Avatar from '../user/Avatar.vue';

const props = defineProps({
    item: {
        title: String,
        created_at: String,
        updated_at: String,
        summary: String,
        number_of_chapters: Number,
        word_count: Number,
    },
    my_story: Boolean,
})

const { open, close } = useModal({
	component: ModalRatings
})

const imgPath = (imgSrc) => { 
    if (imgSrc) {
        return import.meta.env.VITE_API_URL + imgSrc 
    }
    return null
}

</script>

<style lang="scss" scoped>
.story-link {
    &:hover {
        background-color: transparent;
        color: var(--light);
    }
}
</style>