<template>

    <Header :title="chapter?.title" />

    <Container class="">
        <ChapterNav class="chapter-nav" :chapter_number="chapter?.chapter_number" :chapter_list="chapter_list" />

        <div class="story-content">
            <AccessibilityControls />
            <div class="mb-3" v-if="chapter?.summary">
                <h3>Summary</h3>
                <p v-html=chapter?.summary></p>
            </div>
            
            <div class="my-5 content" v-html="chapter?.content"></div>
            
            <div class="mt-3" v-if="chapter?.notes">
                <h3>Notes</h3>
                <p v-html="chapter.notes"></p>
            </div>
            
            <div class="mt-3 mb-4" v-if="chapter?.comments">
                <h3>Comments</h3>

                <div v-if="isLoggedIn" class="border mb-4 p-0">
                    <text-editor v-model="comment" name="comment" :showMenuBar="false" class="p-0 m-0"></text-editor>
                    
                    <div class="row justify-content-end m-0 p-0">
                        <div class="col-lg-2 col-md-4 col-sm-4">
                            <button class="w-100 btn btn-primary" @click="submitComment(chapter.id)">Comment</button>
                        </div>
                    </div>
                </div>

                <div v-else class="mb-4 p-0">
                    <p class="text-center">
                        You must login to comment on this chapter
                    </p>
                </div>

                <Comment v-for="comment in chapter.comments" :comment="comment" @reply="replyComment" @delete="delComment" @edit="editComment" />
            </div>
        </div>
    </Container>

</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { useChapter } from '../../composables/stories/use-get-chapter';
import { useChapterList } from '../../composables/stories/use-get-chapter-list';
import { useRoute } from 'vue-router';
import { onMounted, watch } from 'vue';
import ChapterNav from '../../components/story/ChapterNav.vue';
import Comment from '../../components/app/Comment.vue';
import TextEditor from '../../components/app/utilities/text-editor/TextEditor.vue'
import AccessibilityControls from '../../components/app/utilities/AccessibilityControls.vue';

import { useIsLoggedIn } from '../../composables/use-is-logged-in.ts'
import { useCommentsStore } from '/src/stores/comment.ts'

import ModalComment from '@/components/app/ModalComment.vue'
import { VueFinalModal, useModal, useModalSlot } from 'vue-final-modal'

const { isLoggedIn, getLoggedInUser } = useIsLoggedIn()

const { commentChapter } = useCommentsStore()
const { chapter, getChapters } = useChapter()
const { chapter_list, getChapterList } = useChapterList()
const route = useRoute()

const comment = ref('')
const commentVal = ref('')
const action = ref('')
const actionFunction = ref()

const reply = ref({
    content: '',
    parent_id: 0,
})

const modalInstance = useModal({
    component: VueFinalModal,
    slots: {
        default: useModalSlot({
            component: ModalComment,
            attrs: {
                action: action,
                comment_id: commentVal,
                close: modalClose
            }
        })
    }
})

async function modalClose() { 
    modalInstance.close() 
    await getChapters(route.params?.chapter)
}

onMounted(async () => {
    await getChapters(route.params?.chapter)
    await getChapterList(route.params?.id)
})

watch(() => route.params.chapter, async () => {
    if (route.params.chapter) {
        await getChapters(route.params?.chapter)
    }
})

watch(() => route.params.id, async () => {
    await getChapterList(route.params?.id)
})

function editComment(comment_id) {
    console.log('>>> Edit comment', comment_id)
    action.value = 'edit'
    commentVal.value = comment_id
    modalInstance.open()
}

function replyComment(comment_id) {
    console.log('>>> Reply to comment', comment_id)
    action.value = 'reply'
    commentVal.value = comment_id
    modalInstance.open()
}

function delComment(comment_id) {
    console.log('>>> Delete comment', comment_id)
    action.value = 'delete'
    commentVal.value = comment_id
    modalInstance.open()
}

const submitComment = async (parent_id) => {
    const values = {
        content: comment.value,
        chapter_id: route.params.chapter,
        parent_id: parent_id
    }
    
    console.log('>>> Submit Comment: ', values)
    await commentChapter(values)
    await getChapters(route.params?.chapter)
    comment.value = '' // TODO: Pass event to child
}
</script>