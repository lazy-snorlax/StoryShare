import { useStoryStore, type StoryResource } from "@/stores/story";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useStory() {
    const storyStore = useStoryStore()
    const { story } = storeToRefs(storyStore)

    return {
        story: story as Ref<StoryResource>,
        getStory: storyStore.getStory
    }
}