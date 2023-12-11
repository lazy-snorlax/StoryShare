import { defineStore } from "pinia";
import { MyStoryListResource } from "./my-story";

export const useStoryStore = defineStore('story', {
    state: (): StoryState => ({
        story: null,
        list: []
    }),
    actions: {
        async getStoryList() {
            const response = await this.http.get('stories')
            this.list = response.data.data
        }
    },
})

type StoryState = {
    story: StoryListResource,
    list: Array<StoryListResource>
}

export type StoryListResource = {
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