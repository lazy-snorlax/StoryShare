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
                <h4>Rating</h4>
                <div class="col mx-auto">
                    <MultiSelect class="privacy" v-model="story.rating" :options="ratingList" value-only :allow-empty="false" :no-searching="true" :trackBy="'id'" :label="'name'" />
                </div>
                <div class="col mx-auto">
                    <p>{{ ratingOptionDescription }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <h4>Genre</h4>
                <div class="col mx-auto">
                    <MultiSelect v-model="story.genres" :options="genreList" :allow-empty="false" :trackBy="'id'" :label="'name'" :no-searching="true" :multiple="true" />
                </div>
                <!-- <div class="col mx-auto"></div> -->
            </div>

            <div class="row mb-4">
                <h4>Privacy Settings</h4>
                <div class="col mx-auto">
                    <MultiSelect v-model="story.visible" :options="privacyOptions" value-only :allow-empty="false" :no-searching="true" class="privacy" />
                </div>
                <div class="col mx-auto">
                    <p>{{ privacyOptionDescription }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <h4>Total Number of Chapters</h4>
                <div class="col mx-auto">
                    <input type="number" v-model="story.number_of_chapters" name="number_of_chapters" class="form-control">
                </div>
                <div class="col mx-auto">
                    <p>This is the total number of chapters this story is planned to have. If unsure, type '0'.</p>
                </div>
            </div>

            <div class="row">
                <h4>Summary</h4>
                <p>Write a brief summary or premise for this story. This will be visible at the beginning of every chapter or the start of the story if viewing all chapters at once.</p>
                <text-editor v-model="story.summary" name="summary" />
            </div>
            
            <div class="row mt-4 mb-1">
                <h4>Notes</h4>
                <p>Add any author notes for the overall story here. These will be visible at the end of every chapter or the end of the story if viewing all chapters at once.</p>
                <text-editor v-model="story.notes" @words="notesWordCount" name="notes" />
            </div>

            <div class="row">
                <div class="col-3 mx-auto">
                    <button class="btn w-100" @click="saveStoryDetails">Save</button>
                </div>
                <div class="col-3 mx-auto">
                    <button class="btn btn-danger w-100" style="background-color: red !important;" @click="deleteStory">Delete</button>
                </div>
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

</template>

<script lang="ts" setup>
import { computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'

import { useMyStory } from '../../composables/stories/use-get-my-story'
import { useMyStoryStore, type MyStoryResource } from '../../stores/my-story'

import { useGenreStore } from '../../stores/genres'
import { useRatingStore } from '../../stores/ratings'

import MyChapterListItem from '../../components/app/my-story/my-chapters/MyChapterListItem.vue'
import TextEditor from '../../components/app/utilities/text-editor/TextEditor.vue'
import MultiSelect from '../../components/app/utilities/MultiSelect.vue'
import ModalNewChapter from '../../components/app/my-story/my-chapters/ModalNewChapter.vue'

import { useModal } from 'vue-final-modal'
import { toast, type ToastOptions } from 'vue3-toastify';

const { story, getStory } = useMyStory()
const { saveMyStory, deleteMyStory } = useMyStoryStore()
const route = useRoute()
const router = useRouter()

//  Load genre options into state, use storeToRefs to access pinia stores
const genreStore = useGenreStore()
const { genreList } = storeToRefs(genreStore)

// Load rating options into state
const ratingStore = useRatingStore()
const { ratingList } = storeToRefs(ratingStore)


const privacyOptions = [
    { label: 'Public', value: 'public', description: 'Visible to everyone, with or without an account' },
    { label: 'Protected', value: 'protected', description: 'Visible only to members.' },
    { label: 'Private', value: 'private', description: 'Visible only to you. This will not show in the search results.' },
]

const privacyOptionDescription = computed(() => {
    if (story) {
        return privacyOptions.find((o) => o.value == story.value.visible).description
    }
})

const ratingOptionDescription = computed(() => {
    console.log('>>>> ', story.value.rating.id, ratingList.value)
    if (story && ratingList) {
        return ratingList.value.find((o) => o.id == story.value.rating).description
    }
})

const { open, close } = useModal({
    component: ModalNewChapter,
    attrs: {
        onSubmit(formData) {
            // alert(JSON.stringify(formData, null, 2))
            close()
            router.replace({ name: 'my-stories.chapter.single', params: { chapter: formData.id } })
        },
    },
})

onMounted(async () => {
    ratingStore.getRatingList()
    genreStore.getGenreList()
    await getStory(route.params.id)
})

function notesWordCount(words) {
    if (words == 0) {
        story.value.notes = null
    }
}

const saveStoryDetails = async () => {
    const values = <MyStoryResource>{
        id: story.value.id,
        title: story.value.title,
        summary: story.value.summary,
        rating: story.value.rating,
        notes: story.value.notes,
        number_of_chapters: story.value.number_of_chapters,
        visible: story.value.visible,
        posted: story.value.posted,
        complete: story.value.complete,
        genres: story.value.genres
    }

    // console.log('>>> Story Details: ', values)
    try {
        await saveMyStory(values)
        toast("Story Details Saved", {
            autoClose: 1500,
            position: toast.POSITION.TOP_RIGHT,
            theme: 'colored',
            type: 'success',
        } as ToastOptions);
    } catch (error) {
        toast("Error: Story not saved", {
            autoClose: 1500,
            position: toast.POSITION.TOP_RIGHT,
            theme: 'colored',
            type: 'error',
        } as ToastOptions);
    }
}

const deleteStory = async () => {
    console.log('>>> Delete story: ', story.value.id)
    const values = {
        id: story.value.id
    }

    try {
        await deleteMyStory(values)
        toast("Story Deleted", {
            autoClose: 1500,
            position: toast.POSITION.TOP_RIGHT,
            theme: 'colored',
            type: 'success'
        } as ToastOptions)
        router.replace({ name: 'my-stories' })
    } catch (error) {
        console.log(error)
        toast("Error: Story not deleted", {
            autoClose: 1500,
            position: toast.POSITION.TOP_RIGHT,
            theme: 'colored',
            type: 'error',
        } as ToastOptions);
    }

}
</script>