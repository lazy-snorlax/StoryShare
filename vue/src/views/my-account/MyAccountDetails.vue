<template>
    <Container class="mx-auto p-4">
        <div class="card-wrapper">
            <div class="my-account card">
                <div class="card-body">
                    <div class="mx-auto">
                        <h3>User Details</h3>
                        <div class="mb-3">
                            <label for="name">Display Name</label>
                            <input class="form-control" type="text" name="name" v-bind="name">
                            <small class="text-danger">{{ errors.name }}</small>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input class="form-control" type="text" name="email" v-bind="email">
                            <small class="text-danger">{{ errors.email }}</small>
                        </div>
                        <div class="text-end mt-4">
                            <button class="btn btn-primary" @click="save">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-account card">
                <div class="card-body">
                    <h3>User Profile</h3>
                    <small>This will be visible on your profile.</small>
                    <div class="mt-4 mx-auto avatar-border">
                        <Avatar v-if="loggedInUser?.profile.avatar" :name="loggedInUser?.name" :avatar="loggedInUser?.profile?.avatar" :imgSrc="imgSrc" @click="() => open()" />
                        <a v-else @click="() => open()">
                            <Avatar :name="loggedInUser?.name" />
                        </a>
                    </div>
                    <div class="mt-4">
                        <label for="name">Preferred Language</label>
                        <input class="form-control" type="text" name="language" v-model="language">
                    </div>
                    <div class="text-end mt-4">
                        <button class="btn btn-primary" @click="profileSave">Update</button>
                    </div>
                </div>
            </div>
            <div class="my-account card">
                <div class="card-body">
                    <h3>Profile Description</h3>
                    <small>This will be visible on your profile.</small>
                    <div class="mb-3">
                        <label for="email"></label>
                        <text-editor name="about_me" v-model="aboutMe" />
                    </div>
                    <div class="text-end mt-4">
                        <button class="btn btn-primary" @click="profileSave">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>
<script lang="ts" setup>

import { useForm } from 'vee-validate';
import { useLoggedInUser } from '../../composables/use-logged-in-user';
import { useProfile } from '../../composables/get-profile' 
import { object, string } from 'yup';
import { useAuthStore, type UpdateAccountDetailsForm } from '../../stores/auth'

import TextEditor from '@/components/app/utilities/text-editor/TextEditor.vue'
import Avatar from '../../components/user/Avatar.vue';
import { useFileDialog } from '@vueuse/core'
import { computed, onMounted, ref } from 'vue';

const { loggedInUser } = useLoggedInUser()
const { getProfileImg, saveProfile, updateProfilePic } = useProfile()
const { updateAccountDetails } = useAuthStore()

const {  defineInputBinds, handleSubmit, errors } = useForm<UpdateAccountDetailsForm>({
    validationSchema: object({
        name: string().required(),
        email: string().email().required(),
    }),
    initialValues: {
        name: loggedInUser.value.name,
        email: loggedInUser.value.email,
    }
})

const name = defineInputBinds('name')
const email =  defineInputBinds('email')

const language = ref(loggedInUser?.value.profile.language)
const aboutMe = ref(loggedInUser?.value.profile.about_me)

const imgSrc = computed(() => {
    return import.meta.env.VITE_API_URL + `profile-image/${loggedInUser?.value.id}`
})

const { open, onChange } = useFileDialog({
  multiple: false,
  accept: 'image/png,image/jpeg',
})

onChange(async (files) => {
    console.log('>>> test files: ', files)
    if (!files || files.length === 0) { return }

    loggedInUser.value.profile.avatar = URL.createObjectURL(files[0])
    const payload = new FormData()
    payload.append('file', files[0])

    try {
        await updateProfilePic(payload, loggedInUser?.value.id)
    } catch (error) {
        console.error('>> upload profile img', error)
    }
})

const profileSave = (async () => {
    const values = {
        language: language.value,
        about_me: aboutMe.value,
    }
    await saveProfile(values, loggedInUser?.value.id)
})

const save = handleSubmit(async (values) => {
    await updateAccountDetails(values)
    if (loggedInUser.value.new_email) {
        // TODO: New email verification
        console.log('New email detected')
    } else {
        console.log('Account Details saved successsfully')
    }
})

</script>

<style lang="scss" scoped>

.avatar-border {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--light-alt);
    clip-path: circle();
    width: 11rem;
    height: 11rem;
}

.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--dark);
    font-size: 1.15rem;
    color: var(--light);
    font-weight: 500;
    width: 10rem;
    height: 10rem;
    clip-path: circle();
    margin: 0 auto;
}

.avatar.avatar-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--dark);
    font-size: 1.15rem;
    color: var(--light);
    font-weight: 500;
    width: 10rem;
    height: 10rem;
    clip-path: circle();
    margin: 0 auto;
}

</style>