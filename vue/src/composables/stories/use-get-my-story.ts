import { useMyStoryStore, type MyStoryResource } from "@/stores/my-story";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useMyStory() {
    const myStoryStore = useMyStoryStore()
    const { story } = storeToRefs(myStoryStore)

    return {
        story: story as Ref<MyStoryResource>,
        getStory: myStoryStore.getMyStory
    }
}