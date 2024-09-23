<template>
    <div class="comment">
        <header>
            <h5>{{ comment.user_name }}</h5>
            <p class="timestamp">{{ comment.updated_at == comment.created_at ? comment.created_at : 'Modified: ' + comment.updated_at }}</p>
        </header>
        <!-- <text-editor v-model="comment.content" class="comment-body"  :showMenuBar="false" :editable="false"></text-editor> -->
        <p v-html="comment.content" class="comment-body"></p>
        
        <div class="row justifiy-content-end m-0 p-0" v-if="loggedInUser != null">
          <div v-if="comment.user_id === loggedInUser.id" class="ms-auto p-0 d-flex">
            <div class="col-3 col-sm-3 col-md-2 col-lg-9"></div>
            <button class="col-3 col-sm-3 col-md-3 col-lg-1 mx-1 btn btn-primary" @click="emit('edit', comment.id)"><i class="fa-solid fa-pen-to-square"></i></button>
            <button class="col-3 col-sm-3 col-md-3 col-lg-1 mx-1 btn btn-danger" @click="emit('delete', comment.id)"><i class="fa-solid fa-trash"></i></button>
            <button class="col-3 col-sm-3 col-md-3 col-lg-1 mx-1 btn btn-primary" @click="emit('reply', comment.id)"><i class="fa-solid fa-reply"></i></button>
          </div>
          <div v-else class="ms-auto p-0 d-flex">
            <div class="col col-sm-3 col-md-2 col-lg-11"></div>
            <button class="col-3 col-sm-3 col-md-3 col-lg-1 mx-1 btn btn-primary" @click="emit('reply', comment.id)"><i class="fa-solid fa-reply"></i></button>
          </div>
        </div>
    </div>
    <div class="comment-replies" v-if="comment.replies.length > 0">
        <Comment v-for="reply in comment.replies" :comment="reply" @reply="emitReply" @delete="emitDelete" @edit="emitEdit" />
    </div>
</template>

<script lang="ts" setup>
import { useLoggedInUser } from '../../composables/use-logged-in-user.ts'
import TextEditor from '@/components/app/utilities/text-editor/TextEditor.vue'

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
    (e: 'edit', parent_id: Number) : void
    (e: 'reply', parent_id: Number) : void
    (e: 'delete', comment_id: Number) : void
}>()

// const reply = (id) => { emit('reply', id) }

function emitEdit(id) { emit('edit', id) }
function emitReply(id) { emit('reply', id) }
function emitDelete(id) { emit('delete', id) }

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