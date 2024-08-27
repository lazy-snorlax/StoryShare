import { defineStore } from "pinia"

export const useCommentsStore = defineStore('comments', {
    actions: {
        async getComments(parent_id) {
            const response = await this.http.get('comments/?parent_id=' + parent_id)
            return response.data
        },
        async commentChapter(comment) {
            const response = await this.http.post('comment', comment)
            return response.data
        },
        async deleteComment(comment_id) {
            const response  = await this.http.delete('comment/' + comment_id)
            return response.data
        }
    }
})