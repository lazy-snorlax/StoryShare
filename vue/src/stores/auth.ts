import { defineStore } from "pinia"
import { HttpStatusCode } from "axios"
import { ProfileResource } from "./profile"

export const useAuthStore = defineStore('auth', {
    state: (): AuthState => ({
        user: null,
        csrf: false,
        authenticationAttempted: false,
        is_expanded: false,
        toggleSearchFilters: true,
    }),
    actions: {
        async login(payload: LoginForm) {
            this.authenticationAttempted = false
            await this.http.post('login', payload)
        },

        async logout() {
            await this.http.post('logout')
            this.user = null
            this.csrf = false
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

        async resendVerifyEmail() {
            await this.http.post('auth/verification/resend')
        },

        async updateAccountDetails(payload: UpdateAccountDetailsForm) {
            const response = await this.http.put('user', payload)
            this.user = response.data.data
            this.resendVerifyEmail()
            return this.user
        },

        async updateAccountPassword(payload: UpdatePasswordForm) {
            await this.http.put('user/password', payload)
        },


        // Add Profile Theme
        async saveProfileTheme(id, payload) {
            const response = await this.http.post(`/profile/${id}/theme`, payload)
            this.user = response.data.data
        },

        async setProfileDarkTheme(themeIdx) {
            const response = await this.http.post(`/profile/${this.user.id}/dark`, {
                themeName: themeIdx
            })
            this.user = response.data.data
        },
        async setProfileLightTheme(themeIdx) {
            const response = await this.http.post(`/profile/${this.user.id}/light`, {
                themeName: themeIdx
            })
            this.user = response.data.data
        },

        async getClientIpAddress() {
            this.http.get('https://ipinfo.io/json')
            .then(response => {
                this.ip_address = response.data.ip
            }).catch(error => {
                console.log('>>> Error: ', error)
                this.ip_address = 'localhost' // TODO: Dev route
            })
        },

        toggleSidebar() {
            this.is_expanded = !this.is_expanded
        },

        toggleFilters() {
            this.toggleSearchFilters = !this.toggleSearchFilters
        }
    }

})

type AuthState = {
    user: LoggedInUserResource | null
    csrf: boolean
    authenticationAttempted: boolean
    is_expanded: boolean
    toggleSearchFilters: boolean
}

export type LoggedInUserResource = {
    id: number,
    name: string,
    email: string,
    ip_address: string | null,
    avatar: boolean,
    joined: string,
    language: string,
    about_me: string | null,
    imgSrc: string | null,
    role: RoleResource,
    abilities: AbilityLookupResource[],
    preferences: {
        themes: [] | null
        defaultLight: string | null
        defaultDark: string | null
    }
}

export type RoleResource = {
    name: string
    title: string
    group: string
}

export type AbilityLookupResource = {
    id: number
    name: string
    title: string
    group: string
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