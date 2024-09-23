<template>
    <div class="confirm-modal" content-class="confirm-modal-content">
        <div id="comment-form" class="card">

            <div v-if="action == 'edit'" class="">
                <h4>Edit Comment</h4>
                <div v-html="comment.content" class="quote" />
                <text-editor v-model="comment.content" name="edit" :showMenuBar="false" class="p-0 m-0"></text-editor>

                <div class="row m-0 p-0 d-flex">
                    <button class="col-5 col-lg-2 btn btn-primary" @click="close">Cancel</button>
                    <div class="col-2 col-lg-8"></div>
                    <button class="col-5 col-lg-2 btn btn-primary" @click="submitUpdatedComment(comment.id)">Update</button>
                </div>
            </div>

            <div v-else-if="action == 'reply'" class="">
                <h4>Replying to <span class="">{{ reply.user_name }}</span></h4>
                <div v-html="reply.content" class="quote" />
                <text-editor v-model="comment.content" name="comment" :showMenuBar="false" class="p-0 m-0"></text-editor>

                <div class="row justify-content-end m-0 p-0">
                    <button class="col-5 col-lg-2 btn btn-primary" @click="close">Cancel</button>
                    <div class="col-2 col-lg-8"></div>
                    <button class="col-5 col-lg-2 btn btn-primary" @click="submitComment(reply.id)">Reply</button>
                </div>
            </div>
            
            <div v-else-if="action == 'delete'" class="">
                <h4>Confirm Deletion</h4>
                <div class="quote" v-html="confirmDel.content"></div>

                <div class="row justify-content-end m-0 p-0 d-flex">
                    <button class="col-5 col-lg-2 btn btn-primary" @click="close">Cancel</button>
                    <div class="col-2 col-lg-8"></div>
                    <button class="col-5 col-lg-2 btn btn-danger" @click="submitConfirmDelete(confirmDel.id)">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive, onMounted } from 'vue'
import { useRoute } from 'vue-router';
import { useCommentsStore } from '/src/stores/comment.ts'
import TextEditor from '@/components/app/utilities/text-editor/TextEditor.vue'

const { getComment, commentChapter, deleteComment, updateComment } = useCommentsStore()
const route = useRoute()

const props = defineProps({
    comment_id: { type: Number },
    // user_name: { type: String },
    // content: { type: String },
    // updated_at: { type: String },
    // replies: { type: Array },
    action: { type: String },
    close: { type: Function }
})

const comment = reactive({
    id: 0,
    content: null,
    parent: null
})
const reply = ref({
    content: '',
    parent: null
})
const confirmDel = ref({
    content: '',
    parent: null
})

onMounted(async () => {
    const val = await getComment(props.comment_id)
    if (props.action == 'edit') {
        comment.content = val.data.content
    }
    if (props.action == 'reply') { reply.value = val.data }
    if (props.action == 'delete') { confirmDel.value = val.data }
})

// Edit existing Comment
const submitUpdatedComment = async (parent_id) => {
    const values = {
        id: props.comment_id,
        content: comment.content,
    }
    console.log('>>> Updated Comment: ', values)
    await updateComment(values)
    props.close()
}

// Reply to comment
const submitComment = async (parent_id) => {
    const values = {
        content: comment.content,
        chapter_id: route.params.chapter,
        parent_id: parent_id
    }
    console.log('>>> Submit Comment: ', values)
    await commentChapter(values)
    props.close()
}

// Delete comment
const submitConfirmDelete = async (comment_id) => {
    console.log('>>> Delete Comment: ', comment_id)
    await deleteComment(comment_id)
    props.close()
}

</script>

<style lang="scss">
.confirm-modal {
    display: flex;
    justify-content: center;
    align-items: center;
  }
.confirm-modal-content {
    display: flex;
    flex-direction: column;
    padding: 1rem;
    color: var(--white);
    background-color: var(--dark);
    border-radius: 0.5rem;

    & > * + * {
        margin: 0.5rem 0;
    }

    h1 {
        font-size: 1.375rem;
        color: var(--light-alt);
    }

    .btn {
        background-color: var(--light-alt);
        &:hover {
            background-color: var(--dark-alt);
            color: var(--light-alt);
        }
    }
}
#comment-form {
    background-color: var(--dark);
    border: none;
    color: var(--white);
    padding: 1rem;
    top: 30vh;
    width: 50%;
    .form-control {
        background-color: var(--dark-alt);
        color: var(--white);
        border: none;
        &::placeholder {
            color: var(--primary);
        }
    }
}

.quote {
    background-color: var(--dark-alt);
    border-radius: 5px;
    padding: 0.5rem 1rem;
    margin: 1.5rem 1rem;
    font-style: italic;
}

@media (max-width: 1024px) {
    #comment-form {
        width: 85%;
    }


}

</style>