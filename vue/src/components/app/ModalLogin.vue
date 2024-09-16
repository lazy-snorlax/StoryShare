<template>
    <VueFinalModal
        class="confirm-modal"
        content-class="confirm-modal-content">
        <LoginForm @submit="formData => emit('submit', formData)" />
    </VueFinalModal>
</template>

<script lang="ts" setup>
import LoginForm from './LoginForm.vue'
import { VueFinalModal } from 'vue-final-modal'

const emit = defineEmits<{
    (e: 'submit', formData: FormData): void
}>()

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
    width: 30%;
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
    @media (max-width: 1024px) {
        width: 20rem;
    }
}
</style>