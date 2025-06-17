<template>
    <Container class="mx-auto p-4">
        <div class="card-wrapper">
            <div class="my-account card">
                <div class="card-body">
                    <div class="mx-auto text-center">
                        <h2>Create Site Theme</h2>
                        <div class="row">
                            <h4>Colour Palette</h4>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="primaryColour" @pureColorChange="changeColour('--primary', primaryColour)" />
                                {{ primaryColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="primaryAltColour" @pureColorChange="changeColour('--primary-alt', primaryAltColour)" />
                                {{ primaryAltColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="whiteColour" @pureColorChange="changeColour('--white', whiteColour)" />
                                {{ whiteColour.toString().toUpperCase() }}
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="lightColour" @pureColorChange="changeColour('--light', lightColour)" />
                                {{ lightColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="lightAltColour" @pureColorChange="changeColour('--light-alt', lightAltColour)" />
                                {{ lightAltColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="greyColour" @pureColorChange="changeColour('--grey', greyColour)" />
                                {{ greyColour.toString().toUpperCase() }}
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="darkColour" @pureColorChange="changeColour('--dark', darkColour)" />
                                {{ darkColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="darkAltColour" @pureColorChange="changeColour('--dark-alt', darkAltColour)" />
                                {{ darkAltColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="blackColour" @pureColorChange="changeColour('--black', blackColour)" />
                                {{ blackColour.toString().toUpperCase() }}
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="">Theme Name: </label>
                            <input type="text" v-model="themeName" class="form-control w-50 mx-auto" placeholder="Enter theme name">
                        </div>
                        <div class="mt-4 text-center">
                            <button class="btn btn-primary w-25" @click="saveTheme">Save Theme</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div v-if="loggedInUser?.preferences?.themes" class="my-account card">
                <div class="card-body">
                    <h2 class="text-center">Saved Themes</h2>
                    <div class="mx-auto d-flex row row-cols-auto">
                        <template v-for="(theme, index) in loggedInUser?.preferences?.themes" class="">
                            <div class="col col-sm-12 mx-3 mb-4">
                                <h5 class="text-center">
                                    {{ index }}
                                    <span v-if="index.toString() == loggedInUser?.preferences.defaultDark">(active)</span>
                                </h5>
                                <div class="row mb-2">
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['primary']}`"></div>
                                        {{ theme['primary'] }}
                                    </div>
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['primaryAlt']}`"></div>
                                        {{ theme['primaryAlt'] }}
                                    </div>
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['white']}`"></div>
                                        {{ theme['white'] }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['light']}`"></div>
                                        {{ theme['light'] }}
                                    </div>
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['lightAlt']}`"></div>
                                        {{ theme['lightAlt'] }}
                                    </div>
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['grey']}`"></div>
                                        {{ theme['grey'] }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['dark']}`"></div>
                                        {{ theme['dark'] }}
                                    </div>
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['darkAlt']}`"></div>
                                        {{ theme['darkAlt'] }}
                                    </div>
                                    <div class="col d-flex">
                                        <div class="w-50 h-100 me-2" :style="`background-color: ${theme['black']}`"></div>
                                        {{ theme['black'] }}
                                    </div>
                                </div>
                                <div class="row">
                                    <button v-if="index.toString() !== loggedInUser?.preferences.defaultDark" class="btn btn-primary w-25 text-center mx-auto" @click="setAsDefaultTheme(index, 'dark')">Set as Theme</button>
                                    <button v-else class="btn btn-primary w-25 text-center mx-auto" @click="setAsDefaultTheme(null, 'dark')">Unset Theme</button>
                                    <button class="btn btn-danger w-25 text-center mx-auto" @click="removeTheme(index)">Remove Theme</button>
                                    <!-- <button class="btn btn-primary w-50" @click="setDefaultTheme(index, 'light')">Set as Light</button> -->
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>


<script lang="ts" setup>
import { ref } from "vue";
import { ColorInputWithoutInstance } from "tinycolor2";

import { useLoggedInUser } from '../../composables/use-logged-in-user';
import { changeTheme } from '../../composables/change-theme'

import { useAuthStore } from "../../stores/auth";
import { toast } from 'vue3-toastify';

const { loggedInUser } = useLoggedInUser()
const { loadTheme, changeColour } = changeTheme()
const { saveProfileTheme, removeProfileTheme, setProfileDarkTheme, setProfileLightTheme } = useAuthStore()
const themeName = ref('')

const primaryColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--primary"));
const primaryAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--primary-alt"));
const lightColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--light"));
const lightAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--light-alt"));
const darkColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--dark"));
const darkAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--dark-alt"));

const whiteColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--white"));
const greyColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--grey"));
const blackColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--black"));

const defaultTheme = {
    primary: "#347FC4",
    primaryAlt: "#24598b",
    light: "#e0fbfc",
    lightAlt: "#9Bd7df",
    dark: "#242629",
    darkAlt: "#181a1d",

    white: "#ffffff",
    grey: "#474f5a",
    black: "#000000",
}

const saveTheme = async () => {
    let theme = {
        primary: primaryColour.value.toString().toUpperCase(),
        primaryAlt: primaryAltColour.value.toString().toUpperCase(),
        light: lightColour.value.toString().toUpperCase(),
        lightAlt: lightAltColour.value.toString().toUpperCase(),
        dark: darkColour.value.toString().toUpperCase(),
        darkAlt: darkAltColour.value.toString().toUpperCase(),

        white: whiteColour.value.toString().toUpperCase(),
        grey: greyColour.value.toString().toUpperCase(),
        black: blackColour.value.toString().toUpperCase(),
    }
    console.log(">>>> Theme: ", themeName.value, theme)
    if (themeName.value == "") {
        alert("Theme must have a valid name")
        return
    }
    try {
        await saveProfileTheme(loggedInUser?.value.id, {
            theme,
            themeName: themeName.value
        })
        toast("Theme successfully saved", {
            autoClose: 1500,
            position: toast.POSITION.TOP_RIGHT,
            theme: 'colored',
            type: 'success',
        })
    } catch (error) {
        console.error(error)
        toast("An error has occurred. Theme was not able to be created.", {
            autoClose: 1500,
            position: toast.POSITION.TOP_RIGHT,
            theme: 'colored',
            type: 'error',
        })
    }
}

const setDefaultTheme = () => {
    changeColour('--primary', defaultTheme["primary"])
    changeColour('--primary-alt', defaultTheme["primaryAlt"])
    changeColour('--light', defaultTheme["light"])
    changeColour('--light-alt', defaultTheme["lightAlt"])
    changeColour('--dark', defaultTheme["dark"])
    changeColour('--dark-alt', defaultTheme["darkAlt"])
    changeColour('--white', defaultTheme["white"])
    changeColour('--grey', defaultTheme["grey"])
    changeColour('--black', defaultTheme["black"])
}

const removeTheme = async (themeIdx) => {
    try {
        if (loggedInUser?.value.preferences.defaultDark == themeIdx) {
            setDefaultTheme()
        }
        await removeProfileTheme(loggedInUser?.value.id, themeIdx)
        toast("Theme successfully removed", {
            autoClose: 1500,
            position: toast.POSITION.TOP_RIGHT,
            theme: 'colored',
            type: 'success',
        })
    } catch (error) {
        console.error(error)
        toast("An error has occurred. Theme was not able to be removed.", {
            autoClose: 1500,
            position: toast.POSITION.TOP_RIGHT,
            theme: 'colored',
            type: 'error',
        })
    }
}

const setAsDefaultTheme = (themeIdx, themeType) => {
    console.log(">>>> Themes: ", themeIdx, themeType)
    if (themeType == "dark") {
        setProfileDarkTheme(themeIdx)
    } else {
        setProfileLightTheme(themeIdx)
    }
    
    if (themeIdx == null) {
        setDefaultTheme()
        return
    }

    loadTheme(themeIdx)
    const theme = loggedInUser?.value.preferences.themes[themeIdx]
    primaryColour.value = theme['primary']
    primaryAltColour.value = theme['primaryAlt']
    lightColour.value = theme['light']
    lightAltColour.value = theme['lightAlt']
    darkColour.value = theme['dark']
    darkAltColour.value = theme['darkAlt']

    whiteColour.value = theme['white']
    greyColour.value = theme['grey']
    blackColour.value = theme['black']
    console.log(">>>> Themes: ", loggedInUser?.value.preferences)
}
</script>