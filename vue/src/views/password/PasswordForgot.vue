<template>
    <div class="card card-authentication">
        <div class="card-body p-5">
            <template v-if="sent.value">
                <h1>Password Reset Sent</h1>

                <p class="text-muted">
                    An email has been set to <strong>{{ sent.value }}</strong> with instructions for resetting your password.
                </p>

                <div class="row">
                    <div class="col-auto text-right d-flex align-items-center">
                        <router-link class="small text-muted" :to="{ name: 'login' }" > Back to login </router-link>
                    </div>
                </div>
            </template>
            <template v-else>
                <h1>Forgot Password</h1>
                <p>
                  If you have forgotten your password, enter your email address below to recieve intructions to reset it. The email must be the one used to register.              
                </p>
    
                <div class="mb-3">
                    <label for="">Email Address</label>
                    <input type="text" class="form-control" v-bind="email">
                    <small class="text-danger">{{ errors.email }}</small>
                </div>
    
                <div class="row">
                    <div class="col-auto text-right d-flex align-items-center">
                        <router-link :to="{ name: 'login' }" class="small text-muted"> Return to Login</router-link>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary" @click="next"> Next </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script lang="ts" setup>

import { useForm } from 'vee-validate'
import { useAuthStore, type ForgotPasswordForm } from '../../stores/auth';
import { object, string } from 'yup';

const { emailForgotPassword } = useAuthStore()
const { errors, defineInputBinds, handleSubmit } = useForm<ForgotPasswordForm>({
    validationSchema: object({
        email: string().required()
    })
})

const email = defineInputBinds('email')
const sent = {
    value: null
}

const next = handleSubmit(async (values) => {
    console.log('testing forgot password: ', values)
    await emailForgotPassword(values)
    sent.value = values.email
})

</script>