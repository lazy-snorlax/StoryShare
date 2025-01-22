import { defineStore } from "pinia";
import { StoryListResource } from "./story";

export const useProfileStore = defineStore('profile', {
    state: (): UserProfileState => ({
        profile: null,
    }),
    actions: {
        async getProfile(id: number) {
            const response = await this.http.get('profile/' + id)
            this.profile = response.data.data
        },

        async saveProfile(values: ProfileState, id) {
            console.log('testing profile save', values, id)
            await this.http.put('profile/' + id, values)
        },
    }
})

type UserProfileState = {
    profile: ProfileState | null,
}

export type ProfileResource = {
    name: string,
    avatar: string | null,
    joined: string,
    about_me: string | null,
    language: string,
    recent_stories: Array<StoryListResource>,
    recent_bookmarks: Array<StoryListResource>,
}