import { defineStore } from "pinia";

export const useApplauseStore = defineStore('applause', {
    actions: {
        async applaudeStory(story_id) {
            const response = await this.http.post('applause', {
                story_id: story_id,
                ip_address: '192.168.100.111' // TODO: Client IP address when not logged in
            })

            return response.data.data
        }
    }
})