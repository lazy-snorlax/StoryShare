<template>
    <Header />

    <Container class="user-profile">

        <div class="mb-3 profile">
            <div class="avatar-border">
                <Avatar :name="profile?.name" :avatar="profile?.avatar" :imgSrc="imgSrc" />
            </div>
            <div class="stats">
                <h2 class="text-center">{{ profile?.name }}</h2>
                <h5 class="">Joined: {{ profile?.joined }}</h5> 
                <!-- <h5 class="">Subscribers: 100</h5> -->
                <h5 class="">Language: {{ profile?.language }}</h5> 
            </div>
        </div>

        <div class="mb-3 bio">
            <h3>Description</h3>
            <!-- <text-editor v-model="profile.about_me" name="about_me" :editable="false" :showMenuBar="false" /> -->
            <div class="" v-html="profile.about_me"></div>
        </div>

        <div class="recents">
            <div class="stories" v-if="profile?.recent_stories.length > 0">
                <div class="header">
                    <h3>Recent Stories</h3>
                </div>
                <div class="body">
                    <template v-for="item in profile?.recent_stories">
                        <StoryListItem :item="item" />
                    </template>
                    <div class="footer mt-3 text-end"><a class="">See all stories >></a></div>
                </div>
            </div>
        </div>
        <div class="recents">
            <div class="bookmarks" v-if="profile?.recent_bookmarks.length > 0">
                <div class="header">
                    <h2>Recent Bookmarks</h2>
                </div>
                <div class="body">
                    <template v-for="item in profile?.recent_bookmarks">
                        <StoryListItem :item="item.story" />
                    </template>
                </div>
                <div class="footer mt-3 text-end"><a class="">See all bookmarks >></a></div>
            </div>
        </div>

    </Container>
</template>
<script setup lang="ts">
import { computed, onBeforeMount } from 'vue'
import { useProfile } from '../composables/get-profile';
import { useRoute } from 'vue-router';
import StoryListItem from '../components/story/StoryListItem.vue';
import TextEditor from '@/components/app/utilities/text-editor/TextEditor.vue'

import Avatar from '../components/user/Avatar.vue';

const { profile, getProfile } = useProfile()
const route = useRoute()

const imgSrc = computed(() => {
    if (profile.value.avatar) {
        return import.meta.env.VITE_API_URL + `profile-image/${route.params.id}`
    }
})

onBeforeMount(async () => {
    await getProfile(route.params.id)
})

</script>