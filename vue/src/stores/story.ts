import { defineStore } from "pinia";
import { ChapterListResource } from "./chapter";

export const useStoryStore = defineStore('story', {
    state: (): StoryState => ({
        story: null,
        list: []
    }),
    actions: {
        async getStoryList(filters: URLSearchParams | null) {
            const response = await this.http.get('stories' + (filters ? '?' + filters.toString() : ''))
            this.list = response.data.data
        },

        async getStory(id: number) {
            const response = await this.http.get('stories/' + id)
            this.story = response.data.data
        },
    },
})

type StoryState = {
    story: StoryResource,
    list: Array<StoryListResource>
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