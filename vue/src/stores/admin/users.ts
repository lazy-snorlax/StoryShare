import { defineStore } from "pinia";

const prefix = "/admin/users"
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
            const response = await this.http.get(`${prefix}`)
            this.list = response.data.data
        },
        async getUser(id: number) {
            const response = await this.http.get(`${prefix}/${id}`)
            this.user = response.data.data
        },
        async updateUser(id: number, payload) {
            const response = await this.http.put(`${prefix}/${id}`, payload)
            this.user = response.data.data
        },
        async toggleStatus(id: number) {
            const response = await this.http.put(`${prefix}/${id}/toggle-status` )
            this.user.status = response.data.data.status
            this.user.status_class = response.data.data.status_class
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
    status_class: string,
}

export type UserForm = {
    name: string
    email: string
    password: string
}