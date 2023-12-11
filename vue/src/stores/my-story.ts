import { defineStore } from "pinia"

export const useMyStoryStore = defineStore('my-story', {
    state: (): MyStoryState => ({
        story: null,
        list: []
    }),
    actions: {
        async getMyStoryList() {
            const response = await this.http.get('my-stories')
            this.list = response.data.data
        }
    },
})

type MyStoryState = {
    story: MyStoryListResource,
    list: Array<MyStoryListResource>
}

export type MyStoryListResource = {
    id: number,
    user_id: number,
    title: string,
    summary: string,
    notes: string,
    number_of_chapters: number,
    word_count: number,
    posted: boolean,
    complete: boolean,
    created_at: string,
    updated_at: string,
}