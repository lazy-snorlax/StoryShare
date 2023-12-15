import { useChapterStore, type ChapterListResource } from "../../stores/chapter";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useChapterList() {
    const chapterStore = useChapterStore()
    const { chapter_list } = storeToRefs(chapterStore)

    return {
        chapter_list: chapter_list as Ref<Array<ChapterListResource>>,
        getChapterList: chapterStore.getChapterList
    }
}