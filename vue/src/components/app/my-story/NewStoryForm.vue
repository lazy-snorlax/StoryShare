<template>
    <div class="card">
        <div class="card-body p-5">
            <img src="" alt="" class="logo">
            <h1>Create New Story</h1>

            <p>Before creating a new story, you must give it a title.</p>

            <div class="mb-3">
                <input class="form-control" type="text" v-bind="title" placeholder="Enter title...">
                <small class="text-danger">{{ errors.title }}</small>
            </div>

            <div class="row">
                <div class="col text-end">
                    <button class="btn" @click="submit">Create Story</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useForm } from 'vee-validate';
import { object, string } from 'yup';

const { values, meta, errors, defineInputBinds, handleSubmit } = useForm({
    validationSchema: object({
        title: string().required()
    })
})

const title = defineInputBinds('title')
const emit = defineEmits<{
    (e: 'submit', handleSubmit) : void
}>()

const submit = handleSubmit(async (values) => {
    try {
        console.log('>>> Create new story: ', values)
        emit('submit', values)
    } catch (error) {
        console.log('>>> Error Creating new story: ', values, error)
    }
})

</script>

<style lang="scss">
    .card {
        background-color: var(--light);
        border: none;
        color: var(--white);
        .form-control {
            background-color: var(--dark-alt);
            color: var(--white);
            border: none;
            &::placeholder {
                color: var(--light-alt);
            }
        }
    }
</style>