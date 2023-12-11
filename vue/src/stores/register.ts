import { defineStore } from "pinia"

export const useRegisterStore = defineStore('register', {
    state: () => ({
        form: {}
    }),

    actions: {
        async register(payload: RegisterAccountForm) {
            await this.http.post('register', payload)
        }
    }
})

export type RegisterAccountForm = {
    name: string
    email: string
    password: string
    password_confirmation: string
}