<template>
    <VueFinalModal
        class="confirm-modal"
        content-class="confirm-modal-content">
        <header class="modal-header">
            <h1>{{ title }}</h1>
            <slot name="header"></slot>
        </header>
        <slot name="body"></slot>
        <slot name="footer"></slot>

        <button class="btn" @click="emit('confirm')">Confirm</button>
    </VueFinalModal>
</template>
<script lang="ts" setup>
import { VueFinalModal } from 'vue-final-modal'

const props = defineProps({
    title: String
})

const emit = defineEmits<{
    (e: 'confirm'): void
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
</style>