<template>
    <Container class="mx-auto p-4">
        <div class="card-wrapper">
            <div class="my-account card">
                <div class="card-body">
                    <div class="mx-auto">
                        <h2>Change Site Theme</h2>

                        <color-picker format="hex" v-model:pureColor="primaryColour" @pureColorChange="changeColour('--primary', primaryColour)" />
                        <color-picker format="hex" v-model:pureColor="primaryAltColour" @pureColorChange="changeColour('--primary-alt', primaryAltColour)" />

                        <color-picker format="hex" v-model:pureColor="lightColour" @pureColorChange="changeColour('--light', lightColour)" />
                        <color-picker format="hex" v-model:pureColor="lightAltColour" @pureColorChange="changeColour('--light-alt', lightAltColour)" />

                        <color-picker format="hex" v-model:pureColor="darkColour" @pureColorChange="changeColour('--dark', darkColour)" />
                        <color-picker format="hex" v-model:pureColor="darkAltColour" @pureColorChange="changeColour('--dark-alt', darkAltColour)" />
                    </div>
                </div>
            </div>
            
            <div class="my-account card">
                <div class="card-body">
                    <div class="mx-auto">
                        <h2>Load Saved Theme</h2>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>


<script lang="ts" setup>
import { ref } from "vue";
import { ColorInputWithoutInstance } from "tinycolor2";

const primaryColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--primary"));
const primaryAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--primary-alt"));
const lightColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--light"));
const lightAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--light-alt"));
const darkColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--dark"));
const darkAltColour = ref<ColorInputWithoutInstance>(getComputedStyle(document.documentElement).getPropertyValue("--dark-alt"));

const changeColour = (prop, color) => { document.documentElement.style.setProperty(prop, color) }
</script>