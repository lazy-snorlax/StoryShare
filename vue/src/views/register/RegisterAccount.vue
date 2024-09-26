<template>
    <div class="card card-authentication">
        <div class="card-body p-5">
            <template v-if="sentVerification">
                <h1>Verification Email Sent</h1>
                <p>
                    An email has been sent to <strong>{{ email.value }}</strong> with a link to verify your account.
                    Please check your inbox and verify your address before continuing with account setup.
                </p>
            </template>
            <template v-else>
                <h1>Create a New Account</h1>
    
                <!-- name -->
                <div class="mb-3">
                    <label for="">Account Name</label>
                    <p class="small">This will be your public name. It can be changed later.</p>
                    <input type="text" class="form-control" v-bind="name">
                    <small class="text-danger">{{ errors.name }}</small>
                </div>
                
                <!-- email -->
                <div class="mb-3">
                    <label for="">Email Address</label>
                    <input type="text" class="form-control" v-bind="email">
                    <small class="text-danger">{{ errors.email }}</small>
                </div>
    
                <!-- password -->
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" v-bind="password">
                    <small class="text-danger">{{ errors.password }}</small>
                </div>
                <div class="mb-3">
                    <label for="password">Repeat Password</label>
                    <input class="form-control" type="password" v-bind="password_confirmation">
                    <small class="text-danger">{{ errors.password_confirmation }}</small>
                </div>
                <div class="text-start mt-4">
                    <router-link :to="{ name: 'dashboard' }" class="button">Return to Dashboard</router-link>
                </div>
                <div class="text-end">    
                    <button class="btn btn-primary" @click="register"> Register Account </button>
                </div>
            </template>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { useForm } from 'vee-validate';
import { useRegisterStore, type RegisterAccountForm } from '../../stores/register';
import { object, ref, string } from 'yup';
import { useRouter } from 'vue-router';
import { computed, ref as vRef } from 'vue';

const router = useRouter()
const registerStore = useRegisterStore()

const { defineInputBinds, handleSubmit, values, errors } = useForm<RegisterAccountForm>({
    validationSchema: object({
        name: string().required(),
        email: string().email().required(),
        password: string().required(),
        password_confirmation: string().required().equals([ref('password')], 'The repeated password does not match'),
    })
})

const sentVerification = vRef(false)

const name = defineInputBinds('name')
const email = defineInputBinds('email')
const password = defineInputBinds('password')
const password_confirmation = defineInputBinds('password_confirmation')

const register = handleSubmit(async (values) => {
    try {
        console.log('testing register: ', values)
        await registerStore.register(values)
        // router.replace({ name: 'register.verification' })
        sentVerification.value = true
    } catch ( error ) {
        console.log('Error: ', error)
    }
})

</script>