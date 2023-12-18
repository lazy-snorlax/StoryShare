<template>
    <Header :title="story?.title" />

    <Container class="single-story-details">
        <template v-if="story">
            <div class="row mb-4">
                <h4>Title</h4>
                <div class="col">
                    <input type="text" class="form-control" v-model="story.title" name="title">
                </div>
            </div>

            <div class="row mb-4">
                <h4>Privacy Settings</h4>
                <div class="col mx-auto">
                    <MultiSelect v-model="story.visible" :options="privacyOptions" value-only :allow-empty="false" :no-searching="true" />
                </div>
                <div class="col mx-auto">
                    <p>{{ privacyOptionDescription }}</p>
                </div>
            </div>

            <div class="row">
                <h4>Summary</h4>
                <p>Write a brief summary or premise for this story</p>
                <text-editor v-model="story.summary" name="summary" />
            </div>
            
            <div class="row mt-4 mb-1">
                <h4>Notes</h4>
                <p>Add any author notes for the story as a whole here.</p>
                <text-editor v-model="story.notes" name="notes" />
            </div>

            <div class="row">
                <div class="col-3 mx-auto">
                    <button class="btn w-100" @click="saveStoryDetails">Save</button>
                </div> 
                <!-- <div class="col-3 mx-auto">
                    <button class="btn w-100">
                        Delete
                    </button>
                </div> -->
            </div>

            <!-- Chapter List -->
            <div class="row d-flex mt-1">
                <h2 class="mt-5 text-center">Chapters</h2>
            </div>
            <div class="row">
                <div class="col mx-auto text-center">
                    <button class="btn w-100" @click="open" >Add New Chapter</button>
                </div>
            </div>
            <div class="row">
                <template v-for="chapter in story?.chapters" class="col mx-auto">
                    <MyChapterListItem :chapter="chapter" />
                </template>
            </div>
        </template>
    </Container>

    <ModalsContainer />
</template>

<script lang="ts" setup>
import { computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { Router } from 'vue-router'

import { useMyStory } from '../../composables/stories/use-get-my-story'
import { useMyStoryStore, type MyStoryResource } from '../../stores/my-story'

import { ModalsContainer, useModal } from 'vue-final-modal'

import MyChapterListItem from '../../components/app/my-story/my-chapters/MyChapterListItem.vue'
import TextEditor from '../../components/app/utilities/text-editor/TextEditor.vue'
import MultiSelect from '../../components/app/utilities/MultiSelect.vue'
import ModalNewChapter from '../../components/app/my-story/my-chapters/ModalNewChapter.vue'

const { story, getStory } = useMyStory()
const { saveMyStory } = useMyStoryStore()
const route = useRoute()
const router = useRouter()

const privacyOptions = [
    { label: 'Public', value: 'public', description: 'Visible to everyone, with or without an account' },
    { label: 'Protected', value: 'protected', description: 'Visible only to members.' },
    { label: 'Private', value: 'private', description: 'Visible only to you' },
]

const privacyOptionDescription = computed(() => {
    if (story) {
        return privacyOptions.find((o) => o.value == story.value.visible).description
    }
})

const { open, close } = useModal({
    component: ModalNewChapter,
    attrs: {
        onSubmit(formData) {
            // alert(JSON.stringify(formData, null, 2))
            close()
            router.replace({ name: 'my-stories.chapter.single', params: { id: formData.id } })
        },
    },
})

onMounted(async () => {
    await getStory(route.params.id)
})

const saveStoryDetails = async () => {
    const values = <MyStoryResource>{
        id: story.value.id,
        title: story.value.title,
        summary: story.value.summary,
        notes: story.value.notes,
        visible: story.value.visible,
        posted: story.value.posted,
        complete: story.value.complete,
    }

    // console.log('>>> Story Details: ', values)
    await saveMyStory(values)
}
</script>