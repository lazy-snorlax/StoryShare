import { defineStore } from "pinia";

export const useRatingStore = defineStore('rating', {
    state: (): RatingState => ({
        rating: null,
        ratingList: []
    }),
    actions: {
        async getRatingList() {
            const response = await this.http.get('ratings')
            this.ratingList = response.data.data
        },
    }
})

type RatingState = {
    rating: RatingResource | null,
    ratingList: []
}

export type RatingResource = {
    id: number,
    name: string,
    description: string,
}