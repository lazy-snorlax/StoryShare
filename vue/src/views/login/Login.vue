<template>
    <div class="card card-authentication">
        <div class="card-body">
            <img src="" alt="" class="logo">
            <h1>Log In</h1>

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
                    <a href="" class="small text-muted">Forgot Password?</a>
                </div>
                <div class="col text-end">
                    <router-link to="/" class="button">
                       <button class="btn btn-primary me-1">Dashboard</button>
                    </router-link>
                    <button class="btn btn-primary" @click="submit">Login</button>
                </div>
            </div>
        </div>
    </div>

</template>
  
<script lang="ts" setup>
import { isAxiosError } from 'axios'

import { useAuthStore, type LoginForm } from '../../stores/auth';
import { useRouter, useRoute } from 'vue-router'

import { useForm } from 'vee-validate'
import { object, string, number, date, InferType } from 'yup'

const { login }  = useAuthStore()
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
    } catch ( error ) {
        if (isAxiosError(error) && error.response && error.response.status === 429){

        }
        console.log('>>>> this is an error: ', error)
        throw error
    }
})

</script>
  