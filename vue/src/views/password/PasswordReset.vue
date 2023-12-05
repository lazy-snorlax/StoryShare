<template>
    <div class="card card-authentication">
        <div class="card-body p-5">
            <h1>Set Password</h1>
            <div class="mb-3">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" v-bind="password">
                <small class="text-danger"></small>
            </div>
            <div class="mb-3">
                <label for="password">Repeat Password</label>
                <input class="form-control" type="password" v-bind="password_confirmation">
                <small class="text-danger"></small>
            </div>
            <div class="text-end mt-4">
                <button class="btn btn-primary" @click="save"> Set Password</button>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { useForm } from 'vee-validate';
import { useAuthStore, type ResetPasswordForm } from '../../stores/auth'
import { useRouter, useRoute } from 'vue-router';
import { object, ref, string } from 'yup';
import { isAxiosError } from 'axios';

const props = defineProps<{
  token: string
}>()

const router = useRouter();
const route = useRoute();
const email = route.query['email']

const { defineInputBinds, handleSubmit, values } = useForm<ResetPasswordForm>({
    validationSchema: object({
        password: string().required(),
        password_confirmation: string().required().equals([ref('password')], 'The repeated password does not match'),
    }),
    initialValues: {
        email: email,
        token: props.token,
        password: '',
        password_confirmation: '',
    },
})
const password = defineInputBinds('password')
const password_confirmation = defineInputBinds('password_confirmation')

const { resetPassword } = useAuthStore()

const save = handleSubmit(async (values) => {
    console.log('Testing set password', values)
    try {
        await resetPassword(values);
        
        router.replace({ name: 'login' })
    } catch (error) {
        console.log('Error: ', error)
    }
})

</script>