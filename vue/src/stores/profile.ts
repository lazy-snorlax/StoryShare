import { defineStore } from "pinia";
import { StoryListResource } from "./story";

export const useProfileStore = defineStore('profile', {
    state: (): UserProfileState => ({
        profile: {
            name: '',
            avatar: '',
            joined: '',
            about_me: '',
            language: '',
            recent_stories: [],
            recent_bookmarks: [],
        },
    }),
    actions: {
        async getProfile(id: number) {
            const response = await this.http.get('profile/' + id)
            this.profile = response.data.data
        },

        async saveProfile(values, id) {
            console.log('testing profile save', values, id)
            await this.http.put(`profile/${id}`, values)
        },

        async updateProfilePic(payload, id) {
            console.log('testing profile img save', payload, id)
            await this.http.post(`profile-image/${id}`, payload,
                { headers: { 'Content-Type': undefined }, }
            )
        }
    }
})

type UserProfileState = {
    profile: ProfileResource | null,
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