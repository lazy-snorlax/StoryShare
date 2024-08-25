import { defineStore } from "pinia"

export const useCommentsStore = defineStore('comments', {
    actions: {
        async commentChapter(comment) {
            const response = await this.http.post('comment', comment)
            return response.data
            // .then(response => {
            //     console.log('Successfully added comment')
            // })
        }
    }
})