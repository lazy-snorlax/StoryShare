import { defineStore } from "pinia"
import { HttpStatusCode } from "axios"

export const useAuthStore = defineStore('auth', {
    state: (): AuthState => ({
        user: null,
        csrf: false,
        authenticationAttempted: false
    }),
    actions: {
        async login(payload: LoginForm) {
            const user = await this.http.post('login', payload)
            this.user = user
        },

        async logout() {
            await this.http.post('logout')
            this.user = null
        },

        async getUser() {
            this.authenticationAttempted = true
            const response = await this.http.get('user', {
                userPreflight: true
            })
            this.user = response.data.data
            return this.user
        },

        async emailForgotPassword(payload: ForgotPasswordForm) {
            await this.http.post('password/forgot', payload)  
        },

        async resetPassword(payload: ResetPasswordForm) {
            await this.http.post('password/reset', payload)  
        },

        async updateAccountDetails(payload: UpdateAccountDetailsForm) {
            const response = await this.http.put('user', payload)
            this.user = response.data.data
            return this.user
        },

        async updateAccountPassword(payload: UpdatePasswordForm) {
            await this.http.put('user/password', payload)
        },
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

export type ForgotPasswordForm = {
    email: string
}

export type UpdateAccountDetailsForm = {
    name: string
    email: string
}

export type UpdatePasswordForm = {
    current_password: string
    password: string
    password_confirmation: string
}

export interface ResetPasswordForm {
    email: string | null
    password: string
    password_confirmation: string
    token: string
}