<template>
    <div class="comment">
        <header>
            <h5>{{ comment.user_name }}</h5>
            <p class="timestamp">{{ comment.updated_at }}</p>
        </header>
        <p v-html="comment.content" class="comment-body"></p>
        
        <div class="row justifiy-content-end m-0 p-0">
            <div v-if="comment.user_id === loggedInUser.id" class="col-2 ms-auto p-0 d-flex">
                <button class="w-100 mx-1 btn btn-danger" @click="emit('delete', comment.id)">Delete</button>
                <button class="w-100 mx-1 btn btn-primary" @click="emit('reply', comment.id)">Reply</button>
            </div>
            <div v-else class="col-1 ms-auto p-0 d-flex">
                <button class="w-100 mx-1 btn btn-primary" @click="emit('reply', comment.id)">Reply</button>
            </div>
        </div>
    </div>
    <div class="comment-replies" v-if="comment.replies.length > 0">
        <Comment v-for="reply in comment.replies" :comment="reply"  @reply="emitReply"/>
    </div>
</template>

<script lang="ts" setup>
import { useLoggedInUser } from '../../composables/use-logged-in-user.ts'

const { loggedInUser } = useLoggedInUser()
const props = defineProps({
    comment: {
        id: { type: Number },
        user_name: { type: String },
        content: { type: String },
        updated_at: { type: String },
        replies: { type: Array },
    },
    reply: {
        type: Number,
        required: false,
        default: 0
    }
})
const emit = defineEmits<{
    (e: 'reply', parent_id: Number) : void
    (e: 'delete', comment_id: Number) : void
}>()

// const reply = (id) => { emit('reply', id) }

function emitReply(id) {
    emit('reply', id)
}
</script>

<style lang="scss">
.comment {
  border: 1px solid var(--light-alt);
  border-radius: 0.5rem;
  margin-bottom: 1rem;
  padding: 1.5rem;

  .reply {
    position: relative;
    &::before {
        background-color: silver;
        content: '';
        height: 1px;
        left: -2.5rem;
        position: absolute;
        top: 50%;
        width: 0.75rem;
    }
  }
}

header {
  align-items: center;
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.75rem;
}

.comment-body {
  margin-bottom: 0.375rem;
}

.comment-replies {
    padding-left: 3.5rem;
    padding-right: 0 !important;
    position: relative;

    // &::before {
    //     background-color: lightgray;
    //     content: '';
    //     height: calc(100% - 0.5rem);
    //     left: 0.5rem;
    //     position: absolute;
    //     top: -10px;
    //     width: 1px;
    // }

    // &:last-child::before {
    //     height: calc(100% - 1rem);
    // }
}

h3, p {
  margin: 0;
}

svg {
  fill: SlateGray;
}

.timestamp {
  color: DimGray;
  font-size: 0.8rem;
}
</style>