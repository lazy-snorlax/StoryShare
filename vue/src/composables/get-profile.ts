import { useProfileStore, type ProfileResource } from "../stores/profile";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function useProfile() {
    const profileStore = useProfileStore()
    const { profile, profile_avatar } = storeToRefs(profileStore)

    return {
        profile: profile as Ref<ProfileResource>,
        profile_avatar: profile_avatar,
        getProfile: profileStore.getProfile,
        getProfileImage: profileStore.getProfileImage,
        saveProfile: profileStore.saveProfile,
        updateProfilePic: profileStore.updateProfilePic,
    }
}