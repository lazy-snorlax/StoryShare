import { defineStore } from "pinia"
import { http } from '../utilities/http'

export const useAuthStore = defineStore('auth', {
    state: (): AuthState => ({
        user: null
    }),
    actions: {
        async login(payload: LoginForm) {
            const user = await http.post('login', payload)
            this.user = user
        },

        async logout() {
            await http.post('logout')
            this.user = null
        },
    }

})

type AuthState = {
    user: LoggedInUserResource | null
}

export type LoggedInUserResource = {
    id: number,
    name: string,
    email: string,    
}

export type LoginForm = {
    email: string
    password: string
}