import { defineStore } from "pinia"
import { http } from '../utilities/http'
import { HttpStatusCode } from "axios"

export const useRegisterStore = defineStore('register', {
    state: () => ({
        form: {}
    }),

    actions: {
        async register(payload: RegisterAccountForm) {
            await http.post('register', payload)
        }
    }
})

export type RegisterAccountForm = {
    name: string
    email: string
    password: string
    password_confirmation: string
}