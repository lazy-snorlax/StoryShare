import { defineStore } from "pinia"
import { http } from '../utilities/http'
import { HttpStatusCode } from "axios"

export const useAuthStore = defineStore('auth', {
    state: (): AuthState => ({
        user: null,
        csrf: false,
        authenticationAttempted: false
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

        async getUser() {
            this.authenticationAttempted = true
            const response = await http.get('user', {
                // userPreflight: true
            })
            this.user = response.data.data
            return this.user
        }
    }

})

type AuthState = {
    csrf: boolean
    authenticationAttempted: boolean
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