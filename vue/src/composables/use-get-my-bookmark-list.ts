import { useMyBookmarkStore, type StoryListResource } from "@/stores/my-bookmarks";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export default function useMyBookmarkList() {
    const bookmarkStore = useMyBookmarkStore()
    const { results } = storeToRefs(bookmarkStore)

    return {
        results: results as Ref<Object>,
        getMyBookmarkList: bookmarkStore.getMyBookmarkList
    }
}