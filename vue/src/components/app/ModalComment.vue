<template>
    <div class="confirm-modal" content-class="confirm-modal-content">
        <div id="comment-form" class="card">

            <div v-if="action == 'edit'" class="">
                <h4>Editing Comment</h4>
                <text-editor v-model="comment.content" name="comment" :showMenuBar="false" class="p-0 m-0"></text-editor>

                <div class="row justify-content-end m-0 p-0">
                    <div class="col-lg-2 col-md-4 col-sm-4 d-flex">
                        <button class="w-100 btn btn-primary" @click="submitUpdatedComment(comment.id)">Update</button>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 d-flex">        
                        <button class="w-100 btn btn-primary" @click="close">Cancel</button>
                    </div>
                </div>
            </div>


            <div v-else-if="action == 'reply'" class="">
                <h4>Replying to</h4>
                <p v-html="comment.content"></p>
            </div>
            <div v-else-if="action == 'delete'" class="">
                <h4>Confirm Deletion</h4>
            </div>
            <div v-else class="">None</div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useCommentsStore } from '/src/stores/comment.ts'
import TextEditor from '@/components/app/utilities/text-editor/TextEditor.vue'

const { deleteComment, updateComment } = useCommentsStore()

const props = defineProps({
    comment: {
        id: { type: Number },
        user_name: { type: String },
        content: { type: String },
        updated_at: { type: String },
        replies: { type: Array },
    },
    action: { type: String },
    close: { type: Function }
})

// Edit existing Comment
const submitUpdatedComment = async (parent_id) => {
    console.log('>>> Updated Comment: ', props)
    await updateComment(props.comment)
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
</style>