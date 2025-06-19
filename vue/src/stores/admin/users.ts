import { defineStore } from "pinia";

export const useUserStore = defineStore('user', {
    state: (): UserState => ({
        list: [],
        user: {
            id: 0,
            name: "",
            email: "",
            role: "",
            status: "",
        }
    }),
    actions: {
        async getUsers() {
            const response = await this.http.get('/admin/users')
            this.list = response.data.data
        },
        async getUser(id: number) {
            const response = await this.http.get(`/admin/users/${id}`)
            this.user = response.data.data
        },
    }
})

type UserState = {
    list: Array<UserResource>,
    user: UserResource
}

export type UserResource = {
    id: number,
    name: string,
    email: string,
    role: string,
    status: string,
}

export type UserForm = {
    name: string
    email: string
    password: string
}