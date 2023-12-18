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
        },

        async getMyStory(id: Number) {
            const response = await this.http.get('my-stories/' + id)
            this.story = response.data.data
        },

        async newMyStory(values) {
            const response = await this.http.post('my-stories', values)
            return response.data.data
        },

        async saveMyStory(values: MyStoryResource) {
            const response = await this.http.put('my-stories/' + values.id, values)
        }
    },
})

type MyStoryState = {
    story: MyStoryListResource,
    list: Array<MyStoryListResource>
}

export type MyStoryResource = {
    id: number,
    title: string,
    summary: string,
    notes: string,
    number_of_chapters: number,
    word_count: number,
    visible: string,
    posted: boolean,
    complete: boolean,
}

export type MyStoryListResource = {
    id: number,
    user: string,
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