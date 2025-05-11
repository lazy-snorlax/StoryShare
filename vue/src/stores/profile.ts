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
        profile_avatar: null,
        rerender: 0,
        preferences: {
            themes: [],
            theme: '',
        }
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

        // Profile pic
        async getProfileImage(id: number) {
            const response = await this.http.get(`profile-image/${id}`)
            this.profile_avatar = response.data.data
        },
        async updateProfilePic(payload, id) {
            console.log('testing profile img save', payload, id)
            await this.http.post(`profile-image/${id}`, payload,
                { headers: { 'Content-Type': undefined }, }
            )
        },

        // Add Profile Theme
        async saveProfileTheme(id, payload) {
            const response = await this.http.post(`/profile/${id}/theme`, payload)
            this.themes = response.data.data.preferences.themes
        }
    }
})

type UserProfileState = {
    profile: ProfileResource | null,
    profile_avatar: String | null,
    rerender: number,
    preferences: {
        themes: [] | null,
        theme: string | null,
    }
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