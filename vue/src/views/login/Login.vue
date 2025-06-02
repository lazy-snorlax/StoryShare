<template>
    <div class="card card-authentication">
        <div class="card-body p-3">
            <img src="" alt="" class="logo">
            <h1 class="text-center">Log In</h1>

            <div class="mb-3">
                <label for="">Email Address</label>
                <input class="form-control" type="text" v-bind="email">
                <small class="text-danger">{{ errors.email }}</small>
            </div>

            <div class="mb-3">
                <label for="">Password</label>
                <input class="form-control" type="password" v-bind="password" >
                <small class="text-danger">{{ errors.password }}</small>
            </div>

            <div class="row">
                <div class="col-auto text-right d-flex align-items-center">
                    <router-link :to="{ name: 'forgot-password' }" class="small text-muted">Forgot Password?</router-link>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-start">
                    <router-link to="/" class="">
                       <button class="btn btn-outline-primary me-1">Return to Dashboard</button>
                    </router-link>
                </div>
                <div class="col text-end">
                    <button class="btn btn-primary px-4" @click="submit">Login</button>
                </div>
            </div>
        </div>
    </div>

</template>
  
<script lang="ts" setup>
import { AxiosError, isAxiosError } from 'axios'
import { storeToRefs } from 'pinia'
import { onMounted, watch } from 'vue';

import { useAuthStore, type LoginForm } from '../../stores/auth';
import { useRouter, useRoute } from 'vue-router'

import { useLoggedInUser } from '../../composables/use-logged-in-user';

import { useForm } from 'vee-validate'
import { object, string, number, date, InferType } from 'yup'

const authStore  = useAuthStore()
const { login }  = useAuthStore()
const { loggedInUser } = useLoggedInUser()

const { user, error } = storeToRefs(authStore)

const router = useRouter()
const route = useRoute()

const { values, meta, errors, defineInputBinds, handleSubmit } = useForm<LoginForm>({
    validationSchema: object({
        email: string().email().required(),
        password: string().required()
    })
})

const email = defineInputBinds('email')
const password = defineInputBinds('password')

const submit = handleSubmit(async (values) => {
    try {
        await login(values)

        if (route.query.redirect) {
            router.replace(route.query.redirect as string)
        } else {
            router.replace({ name: 'dashboard' })
        }
    } catch (error) {
        if (isAxiosError(error) && error.response && error.response.status === 429) {
            // TODO: Too many attempts error
            return
        }
        if (isAxiosError(error) && error.response && error.response.status === 422) {
            alert(error.response.data.message)
            return
        }
        throw error.response
    }
    // If login unsuccessful, alert user
    // if (typeof user.value === undefined || typeof user.value === null) {
    // } 
    // else {
    //     // else successful login, reroute to dashboard
    // }
})


</script>
   