import { useProfileStore, type ProfileResource } from "../stores/profile";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useProfile() {
    const profileStore = useProfileStore()
    const { profile } = storeToRefs(profileStore)

    return {
        profile: profile as Ref<ProfileResource>,
        getProfile: profileStore.getProfile,
        saveProfile: profileStore.saveProfile,
        updateProfilePic: profileStore.updateProfilePic,
    }
}