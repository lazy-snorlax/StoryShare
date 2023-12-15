import { useChapterStore, type ChapterResource } from "../../stores/chapter";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useChapter() {
    const chapterStore = useChapterStore()
    const { chapter } = storeToRefs(chapterStore)

    return {
        chapter: chapter as Ref<ChapterResource>,
        getChapters: chapterStore.getChapters
    }
}