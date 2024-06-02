import { defineStore } from "pinia";
import StoryListResource from "story.ts"

export const useMyBookmarkStore = defineStore('my-bookmark', {
    state: (): MyBookmarkState => ({
        results: {
            list: [],
            pagination: {
                total: 0
            }
        }
    }),
    actions: {
        async getMyBookmarkList(filters, page = 1) {
            const response = await this.http.get('my-bookmarks?page='+page, filters)
            this.results.list = response.data.data
            this.results.pagination = response.data.meta
        },

        async saveMyBookmark(values) {
            const response = await this.http.post('my-bookmarks', values)
            return response.data.data
        }
    },
})

type MyBookmarkState = {
    results: {
        list: Array<StoryListResource>,
        pagination: Object
    }
}