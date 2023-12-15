import { useChapterStore, type ChapterResource } from "../../stores/chapter";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useAllChapters() {
    const chapterStore = useChapterStore()
    const { all_chapters } = storeToRefs(chapterStore)

    return {
        all_chapters: all_chapters as Ref<Array<ChapterResource>>,
        getAllChapters: chapterStore.getAllChapters
    }
}