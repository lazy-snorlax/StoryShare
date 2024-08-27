<template>

    <Header :title="chapter?.title" />

    <Container class="">
        <ChapterNav class="chapter-nav" :chapter_number="chapter?.chapter_number" :chapter_list="chapter_list" />

        <div class="story-content">
            <div class="mb-3" v-if="chapter?.summary">
                <h3>Summary</h3>
                <p v-html=chapter?.summary></p>
            </div>    
            
            <div class="my-5 content" v-html="chapter?.content"></div>
            
            <div class="mt-3" v-if="chapter?.notes">
                <h3>Notes</h3>
                <p v-html="chapter.notes"></p>
            </div>
            
            <div class="mt-3" v-if="chapter?.comments">
                <h3>Comments</h3>

                <div v-if="isLoggedIn" class="border mb-4 p-0">
                    <text-editor v-model="comment" name="comment" :showMenuBar="false" class="p-0 m-0"></text-editor>
                    
                    <div class="row justify-content-end m-0 p-0">
                        <div class="col-lg-2 col-md-4 col-sm-4">
                            <button class="w-100 btn btn-primary" @click="submitComment(chapter.id)">Comment</button>
                        </div>
                    </div>
                </div>

                <Comment v-for="comment in chapter.comments" :comment="comment" @reply="replyComment" @delete="deleteComment"/>
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

import { useIsLoggedIn } from '../../composables/use-is-logged-in.ts'
import { useCommentsStore } from '/src/stores/comment.ts'

const { isLoggedIn, getLoggedInUser } = useIsLoggedIn()

const { commentChapter, deleteComment } = useCommentsStore()
const { chapter, getChapters } = useChapter()
const { chapter_list, getChapterList } = useChapterList()
const route = useRoute()

const comment = ref('')
const reply = ref({
    content: '',
    parent_id: 0,
})

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

function replyComment(comment_id) {
    console.log('>>> Reply to comment_id', comment_id)
    reply.value.parent_id = comment_id
    //  Open Modal to reply to a comment
}

function deleteCom(comment_id) {
    console.log('>>> Delete comment_id', comment_id)
    // Open modal to confirm deletion
}

const submitComment = async (parent_id) => {
    const values = {
        content: comment.value,
        parent_id: parent_id
    }

    console.log('>>> Submit Comment: ', values)
    await commentChapter(values)
    comment.value = ''
}

const commentDel = async (comment_id) => {
    console.log('>>> Delete Comment: ', values)
    await deleteComment(comment_id)
}
</script>