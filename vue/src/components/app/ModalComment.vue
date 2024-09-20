<template>
    <div class="confirm-modal" content-class="confirm-modal-content">
        <div id="comment-form" class="card">
            <h2>Comment Modal</h2>
            <div v-if="action == 'edit'" class="">
                Edit
            </div>
            <div v-else-if="action == 'reply'" class="">
                Reply
            </div>
            <div v-else-if="action == 'delete'" class="">
                Delete
            </div>
            <div v-else class="">None</div>
        </div>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps({
    comment: {
        id: { type: Number },
        user_name: { type: String },
        content: { type: String },
        updated_at: { type: String },
        replies: { type: Array },
    },
    action: { type: String }
})
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