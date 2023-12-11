import { useStoryStore, type StoryListResource } from "@/stores/story";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useStoryList() {
    const storyStore = useStoryStore()
    const { list } = storeToRefs(storyStore)

    return {
        list: list as Ref<Array<StoryListResource>>,
        getStoryList: storyStore.getStoryList
    }
}