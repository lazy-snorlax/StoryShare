import { defineStore } from "pinia";

export const useGenreStore = defineStore('genre', {
    state: (): GenreState => ({
        genre: null,
        genreList: []
    }),
    actions: {
        async getGenreList() {
            const response = await this.http.get('genres')
            this.genreList = response.data.data
        },
    }
})

type GenreState = {
    genre: GenreResource,
    genreList: Array<GenreResource>
}

export type GenreResource = {
    id: number,
    name: string
}