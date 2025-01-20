<template>
    <Header />

    <Container class="user-profile">

        <div class="mb-3 profile">
            <div class="profile-pic">
                <img :src="profile" alt="profile.jpg" class="">
            </div>
            <div class="stats">
                <h2 class="text-center">{{ profile?.name }}</h2>
                <h5 class="">Joined: {{ profile?.joined }}</h5> 
                <!-- <h5 class="">Subscribers: 100</h5> -->
                <h5 class="">Language: {{ profile?.language }}</h5> 
            </div>
        </div>

        <div class="mb-3 bio">
            <h2>Description</h2>
            {{ profile?.about_me }}
        </div>

        <div class="recents">
            <div class="stories">
                <div class="header">
                    <h2>Recent Stories</h2>
                </div>
                <div class="body">
                    <template v-for="item in profile?.recent_stories">
                        <StoryListItem :item="item" />
                    </template>
                </div>
                <div class="footer mt-3 text-end"><a class="">See all stories >></a></div>
            </div>
        </div>
        <div class="recents">
            <div class="bookmarks">
                <div class="header">
                    <h2>Recent Bookmarks</h2>
                </div>
                <div class="body">
                    <template v-for="item in profile?.recent_bookmarks">
                        <StoryListItem :item="item" />
                    </template>
                </div>
                <div class="footer mt-3 text-end"><a class="">See all bookmarks >></a></div>
            </div>
        </div>

    </Container>
</template>
<script setup lang="ts">
import { computed, onBeforeMount, reactive, watchEffect } from 'vue'
import { useProfileStore } from '../stores/profile';
import { useRoute } from 'vue-router';
import { storeToRefs } from "pinia";

import StoryListItem from '../components/story/StoryListItem.vue';

import logoDefault from '@/assets/logo.svg'
import profileExample from '../assets/profile_example.jpg'

// const profile = computed(() => { return profileExample })
// const logo = computed(() => { return logoDefault })

const { getProfile } = useProfileStore()
const { profile } = storeToRefs(useProfileStore())
const route = useRoute()

onBeforeMount(async () => {
    await getProfile(route.params.id)
})

</script>