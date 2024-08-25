import { defineStore } from "pinia";

export const useChapterStore = defineStore('chapter', {
    state: (): ChapterState => ({
        chapter_list: null,
        chapter: null,
        all_chapters: null
    }),
    actions: {
        async getChapterList(story_id: Number) {
            const response =  await this.http.get(`stories/${story_id}/chapter-list`)
            this.chapter_list = response.data.data
        },
        
        async getChapters(chapter_id: Number | null) {
            const response = await this.http.get(`chapters` + (chapter_id ? '/' + chapter_id : ''))
            this.chapter = response.data.data
        },
        
        async getAllChapters(story_id: Number) {
            const response = await this.http.get(`chapters` + (story_id ? '?story_id=' + story_id : ''))
            this.all_chapters = response.data.data
        },

        // My-Chapters
        async getMyChapter(id: Number) {
            const response = await this.http.get(`my-chapters/${id}`)
            this.chapter = response.data.data
        },

        async updateMyChapter(values: ChapterResource) {
            console.log('>>> Save Vals: ', values)
            const response = await this.http.put(`my-chapters/${values.id}`, values)
        },

        async newChapter(values) {
            const response = await this.http.post('my-chapters', values)
            return response.data.data
        }
    }
})

type ChapterState = {
    chapter_list: Array<ChapterListResource>,
    chapter: ChapterResource,
    all_chapters: Array<ChapterResource>,
}

export type ChapterResource = {
    id: number,
    chapter_number: number,
    title: string,
    summary: string,
    content: string,
    comments: Array<Object>
    notes: string,
    word_count: number
    updated_at: string,
}

export type ChapterListResource = {
    id: number,
    chapter_number: number,
    title: string,
    summary: string,
    updated_at: string,
}