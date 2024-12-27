<template>
    <VueFinalModal
        class="confirm-modal"
        content-class="confirm-modal-content">
        <h1>Ratings</h1>
        <p>This explains the meaning of each of the ratings</p>
        <div class="" v-for="rating in ratingList">
            <div class="d-flex my-3">
                <div class="rating me-3" :class="`${ rating.name.toLowerCase().replace(' ', '-') }`" @click="open">{{ rating.name[0] }}</div>
                <p class="">{{ rating.description }}</p>
            </div>
        </div>
    </VueFinalModal>
</template>

<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { VueFinalModal } from 'vue-final-modal'

import { useRatingStore } from '@/stores/ratings';
const ratingStore = useRatingStore()
const { ratingList } = storeToRefs(ratingStore)
ratingStore.getRatingList()

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
.rating {
    font-size: 1.75rem;
    text-align: center;
    width: 3rem;
    border-radius: 15%;
    &.general { background-color: green; }
    &.teen { background-color: gold; }
    &.young-adult { background-color: skyblue; }
    &.mature { background-color: orange; }
    &.explicit { background-color: red; }
}
</style>