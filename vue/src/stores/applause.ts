import { defineStore } from "pinia";

export const useApplauseStore = defineStore('applause', {
    actions: {
        async applaudeStory(story_id, ip_address = null) {
            await this.http.post('applause', {
                story_id: story_id,
                ip_address: ip_address // TODO: Client IP address when not logged in
            }).then(response => {
                alert(response.data)
            }).catch(error => {
                alert(error.response.data.message)
            })
        }
    }
})