<template>
    <Header :title="'My Stories'" />
    
    <Container class="container-max-xl mx-auto p-4" >
        <div class="chapter-nav">
            <div class="row my-3 d-flex">
                <div class="col-3 mx-auto text-center">
                    <button class="chapter-btn btn" @click="open">Create New Story</button>
                </div>
            </div>
        </div>

        <div v-for="item in list">
            <StoryListItem :item="item" :my_story="true" />
        </div>
    </Container>

</template>
<script lang="ts" setup>
import { useMyStoryStore } from '../../stores/my-story';
import { onMounted } from 'vue';
import { useMyStoryList } from '../../composables/stories/use-get-my-story-list';
import StoryListItem from '../../components/story/StoryListItem.vue';
import ModalNewStoryForm from '../../components/app/my-story/ModalNewStoryForm.vue';

import { useRouter } from 'vue-router';
import { useModal } from 'vue-final-modal'


const router = useRouter()

const myStoryStore = useMyStoryStore()
const { list } = useMyStoryList()

const { open, close } = useModal({
    component: ModalNewStoryForm,
    attrs: {
        onSubmit(formData) {
            // alert(JSON.stringify(formData, null, 2))
            close()
            router.replace({ name: 'my-stories.single', params: { id: formData.id } })
        },
    },
})

onMounted(async () => {
    await myStoryStore.getMyStoryList()
})

</script>
