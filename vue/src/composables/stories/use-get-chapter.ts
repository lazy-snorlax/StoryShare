import { useStoryStore, type ChapterResource } from "../../stores/story";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useChapter() {
    const storyStore = useStoryStore()
    const { chapter } = storeToRefs(storyStore)

    return {
        chapter: chapter as Ref<ChapterResource>,
        getChapters: storyStore.getChapters
    }
}