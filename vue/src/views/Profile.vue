<template>
    <Header :title="''" />

    <Container class="">

        <h1 class="text-center">Profile Name</h1>
        <div class="mb-3 profile">
            <div class="profile-pic">
                <img :src="profile" alt="profile.jpg" class="">
            </div>
            <div class="blurb">
                <h2>Bio</h2>
                <p>Lorem ipsum odor amet, consectetuer adipiscing elit. Urna donec porttitor hendrerit tortor fames quisque. Primis scelerisque sem quam enim tortor id pretium dui. Euismod feugiat sollicitudin tempor, semper urna maecenas magna placerat. Ullamcorper nibh diam eleifend rutrum, mollis porta parturient. Sem fames odio nam aptent nec eu felis.</p>
                <p>Vel imperdiet dapibus purus tristique maximus at. Ultrices pretium fermentum vivamus malesuada penatibus feugiat. Varius et taciti aliquam nostra blandit natoque dictumst bibendum ex. Euismod mus varius dignissim nec a; sagittis hendrerit praesent. Phasellus etiam nunc risus; vivamus in odio sollicitudin risus phasellus. Sociosqu mattis arcu taciti tellus consectetur duis facilisi. Augue commodo justo varius scelerisque nunc dolor velit. Leo nisi pellentesque mollis turpis fringilla.</p>
            </div>
        </div>

        <div class="recents">
            <div class="stories">
                <h2>Recent Stories</h2>
            </div>
            <div class="bookmarks">
                <h2>Recent Bookmarks</h2>
            </div>
        </div>

    </Container>
</template>
<script setup lang="ts">
import { computed, reactive, watchEffect } from 'vue'
import profileExample from '../assets/profile_example.jpg'

const profile = computed(() => { return profileExample })

</script>