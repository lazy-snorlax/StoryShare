import { defineStore } from "pinia"

export const useCommentsStore = defineStore('comments', {
    actions: {
        // Get comment
        async getComment(comment_id) {
            const response = await this.http.get('comment/' + comment_id)
            return response.data
        },
        // Get all comments for a parent
        async getComments(parent_id) {
            const response = await this.http.get('comments/?parent_id=' + parent_id)
            return response.data
        },
        // Submit a comment, parent_id & type should be in form body
        async commentChapter(comment) {
            const response = await this.http.post('comment', comment)
            return response.data
        },
        // Edit existing comment
        async updateComment(comment) {
            console.log('>>> updateComment: ', comment)
            const response  = await this.http.put('comment/' + comment.id, comment)
            return response.data
        },
        // Delete existing comment
        async deleteComment(comment_id) {
            const response  = await this.http.delete('comment/' + comment_id)
            return response.data
        }
    }
})