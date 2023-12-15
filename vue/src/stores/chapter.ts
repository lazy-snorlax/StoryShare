import { defineStore } from "pinia";

export const useChapterStore = defineStore('chapter', {
    state: (): ChapterState => ({
        chapter_list: null,
        chapter: null
    }),
    actions: {
        async getChapterList(story_id: Number) {
            const response =  await this.http.get(`stories/${story_id}/chapter-list`)
            this.chapter_list = response.data.data
        },
        
        async getChapters(id: Number) {
            const response = await this.http.get('chapters' + (id ? '/' + id : ''))
            this.chapter = response.data.data
        }
    }
})

type ChapterState = {
    chapter_list: Array<ChapterListResource>,
    chapter: ChapterResource
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