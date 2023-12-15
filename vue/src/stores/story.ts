import { defineStore } from "pinia";

export const useStoryStore = defineStore('story', {
    state: (): StoryState => ({
        story: null,
        chapter: null,
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

        async getChapters(id: Number) {
            const response = await this.http.get('chapters' + (id ? '/' + id : ''))
            this.chapter = response.data.data
        }
    },
})

type StoryState = {
    story: StoryResource,
    chapter: ChapterResource,
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

export type ChapterResource = {
    id: number,
    chapter_number: number,
    title: string,
    summary: string,
    content: string,
    updated_at: string,
}

export type ChapterListResource = {
    id: number,
    chapter_number: number,
    title: string,
    summary: string,
    updated_at: string,
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