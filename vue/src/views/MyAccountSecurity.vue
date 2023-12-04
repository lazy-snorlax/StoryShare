<template>
    <Container class="container-max-sm mx-auto p-4">
        <div class="mx-auto">
            <h2>Change Password</h2>

            <div class="mb-3">
                <label for="password">Current Password</label>
                <input class="form-control" type="password" v-bind="current_password">
                <small class="text-danger"></small>
            </div>

            <div class="mb-3">
                <label for="password">New Password</label>
                <input class="form-control" type="text" name="password" v-bind="password">
                <small class="text-danger"></small>
            </div>

            <div class="mb-3">
                <label for="password">Repeat New Password</label>
                <input class="form-control" type="text" v-bind="password_confirmation">
                <small class="text-danger"></small>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn-primary" @click="save">Change Password</button>
            </div>
        </div>
    </Container>
</template>
<script lang="ts" setup>

import { useForm } from 'vee-validate';
import { useAuthStore, type UpdatePasswordForm } from '../stores/auth'
import { object, string } from 'yup';

const { updateAccountPassword } = useAuthStore()

const { defineInputBinds, handleSubmit } = useForm<UpdatePasswordForm>({
    validationSchema: object({
        current_password: string().required(),
        password: string().required(),
        password_confirmation: string().required(),
    })
})

const current_password = defineInputBinds('current_password')
const password = defineInputBinds('password')
const password_confirmation = defineInputBinds('password_confirmation')

const save = handleSubmit(async (values, { resetForm }) => {
    console.log(values)
    // TODO: Update Account Password
    // await updateAccountPassword(values)
    // console.log('Password saved succesfully')

    // resetForm()
})

</script>