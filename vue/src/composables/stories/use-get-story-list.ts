import { useStoryStore, type StoryListResource } from "@/stores/story";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useStoryList() {
    const storyStore = useStoryStore()
    const { results } = storeToRefs(storyStore)

    return {
        results: results as Ref<Object>,
        getStoryList: storyStore.getStoryList
    }
}