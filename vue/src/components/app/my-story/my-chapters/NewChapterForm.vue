<template>
    <div id="story-form" class="card">
        <div class="card-body p-5">
            <img src="" alt="" class="logo">
            <h1>Add a new chapter</h1>

            <p>Before adding a new chapter, you must give it a title.</p>

            <div class="mb-3">
                <input class="form-control" type="text" v-bind="title" placeholder="Enter chapter title...">
                <small class="text-danger">{{ errors.title }}</small>
            </div>

            <div class="row">
                <div class="col text-end">
                    <button class="btn" @click="submit">Add Chapter</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useForm } from 'vee-validate';
import { number, object, string } from 'yup';
import { useChapterStore } from '../../../../stores/chapter';
import { useRoute } from 'vue-router';

const emit = defineEmits<{
    (e: 'submit', handleSubmit) : void
}>()

const route = useRoute()
const { newChapter } = useChapterStore()

const { values, meta, errors, defineInputBinds, handleSubmit } = useForm({
    validationSchema: object({
        title: string().required(),
        story_id: number().required(),
    }),
    initialValues: {
        title: null,
        story_id: route.params.id,
    }
})
const title = defineInputBinds('title')

const submit = handleSubmit(async (values) => {
    try {
        const response = await newChapter(values)
        emit('submit', response)
    } catch (error) {
        console.log('>>> Error Creating new story: ', values, error.message)
    }
})

</script>

<style lang="scss">
    #story-form {
        background-color: var(--dark);
        border: none;
        color: var(--white);
        .form-control {
            background-color: var(--dark-alt);
            color: var(--white);
            border-color: var(--grey);
            &::placeholder {
                color: var(--primary);
            }
        }
    }
</style>