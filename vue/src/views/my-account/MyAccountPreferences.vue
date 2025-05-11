<template>
    <Container class="mx-auto p-4">
        <div class="card-wrapper">
            <div class="my-account card">
                <div class="card-body">
                    <div class="mx-auto text-center">
                        <h2>Change Site Theme</h2>
                        <div class="row">
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="primaryColour" @pureColorChange="changeColour('--primary', primaryColour)" />
                                {{ primaryColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="lightColour" @pureColorChange="changeColour('--light', lightColour)" />
                                {{ lightColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="darkColour" @pureColorChange="changeColour('--dark', darkColour)" />
                                {{ darkColour.toString().toUpperCase() }}
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="primaryAltColour" @pureColorChange="changeColour('--primary-alt', primaryAltColour)" />
                                {{ primaryAltColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="lightAltColour" @pureColorChange="changeColour('--light-alt', lightAltColour)" />
                                {{ lightAltColour.toString().toUpperCase() }}
                            </div>
                            <div class="col">
                                <color-picker format="hex" v-model:pureColor="darkAltColour" @pureColorChange="changeColour('--dark-alt', darkAltColour)" />
                                {{ darkAltColour.toString().toUpperCase() }}
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
            
            <div v-if="loggedInUser?.preferences.themes" class="my-account card">
                <div class="card-body">
                    <h2 class="text-center">Saved Theme</h2>
                    <div class="mx-auto d-flex">
                        <template v-for="(theme, index) in loggedInUser?.preferences.themes" class="">
                            <div class="col-3 mx-3">
                                <h5 class="text-center">{{ index }}</h5>
                                <div class="row">
                                    <div class="col">
                                        <color-picker format="hex" v-model:pureColor="theme['primary']" />
                                        {{ theme['primary'] }}
                                    </div>
                                    <div class="col">
                                        <color-picker format="hex" v-model:pureColor="theme['primaryAlt']" />
                                        {{ theme['primaryAlt'] }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <color-picker format="hex" v-model:pureColor="theme['light']" />
                                        {{ theme['light'] }}
                                    </div>
                                    <div class="col">
                                        <color-picker format="hex" v-model:pureColor="theme['lightAlt']" />
                                        {{ theme['lightAlt'] }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <color-picker format="hex" v-model:pureColor="theme['dark']" />
                                        {{ theme['light'] }}
                                    </div>
                                    <div class="col">
                                        <color-picker format="hex" v-model:pureColor="theme['darkAlt']" />
                                        {{ theme['darkAlt'] }}
                                    </div>
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
import { useProfileStore } from "../../stores/profile";
import { toast } from 'vue3-toastify';

const { loggedInUser } = useLoggedInUser()
const { saveProfileTheme } = useProfileStore()
const themeName = ref('')

const primaryColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--primary"));
const primaryAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--primary-alt"));
const lightColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--light"));
const lightAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--light-alt"));
const darkColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--dark"));
const darkAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--dark-alt"));

const changeColour = (prop, color) => { document.documentElement.style.setProperty(prop, color) }

const saveTheme = async () => {
    let theme = {
        primary: primaryColour.value.toString().toUpperCase(),
        primaryAlt: primaryAltColour.value.toString().toUpperCase(),
        light: lightColour.value.toString().toUpperCase(),
        lightAlt: lightAltColour.value.toString().toUpperCase(),
        dark: darkColour.value.toString().toUpperCase(),
        darkAlt: darkAltColour.value.toString().toUpperCase(),
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
</script>