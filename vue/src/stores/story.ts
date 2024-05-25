import { defineStore } from "pinia";
import { ChapterListResource } from "./chapter";

export const useStoryStore = defineStore('story', {
    state: (): StoryState => ({
        story: null,
        results: {
            list: [],
            pagination: {
                total: 0
            }
        }
    }),
    actions: {
        async getStoryList(filters, page = 1) {
            const response = await this.http.post('stories?page='+page, 
                filters
            )
            this.results.list = response.data.data
            this.results.pagination = response.data.meta
        },

        async getStory(id: number) {
            const response = await this.http.get('stories/' + id)
            this.story = response.data.data
        },
    },
})

type StoryState = {
    story: StoryResource,
    results: {
        list: Array<StoryListResource>,
        pagination: Object
    }
}

export type StoryResource = {
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
    chapters: Array<ChapterListResource> | null,
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