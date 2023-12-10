import { useMyStoryStore, type StoryListResource } from "@/stores/my-story";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useMyStoryList() {
    const myStoryStore = useMyStoryStore()
    const { list } = storeToRefs(myStoryStore)

    return {
        list: list as Ref<Array<StoryListResource>>,
        getStoryList: myStoryStore.getStoryList
    }
}