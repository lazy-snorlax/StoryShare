<template>
    <div class="accessibility-controls">
        <button type="button" class="" @click="changeFontSize('-0.1')">
            <i class="fa-solid fa-font"></i> <i class="fa-solid fa-minus"></i>
        </button>
        <button type="button" class="" @click="resetFont">
            <i class="fa-solid fa-rotate-right"></i> <i class="fa-solid fa-font"></i>
        </button>
        <button type="button" class="" @click="changeFontSize('0.1')">
            <i class="fa-solid fa-font"></i> <i class="fa-solid fa-plus"></i>
        </button>
        <select class="font-select" @change="changeFont">
            <option v-for="font in fontOptions" :value="font">{{ font }}</option>
        </select>
    </div>
</template>

<script setup lang="ts">
    const fontOptions = [
        "Fira sans",
        "Helvetica",
        "Verdana",
        "Calibri",
    ]

    const changeFontSize = (size) => {
        let currentSize = getComputedStyle(document.documentElement).getPropertyValue("--story-font-size")
        document.documentElement.style.setProperty("--story-font-size", (parseFloat(currentSize) * 1 + parseFloat(size))+"rem")
    }
    const resetFont = () => {
        document.documentElement.style.setProperty("--story-font-size", "1rem")
        document.documentElement.style.setProperty("--story-font-family", "Fira sans")
    }

    const changeFont = (event) => {
        document.documentElement.style.setProperty("--story-font-family", event?.target.value)
    }
</script>

<style lang="scss" scoped>
.accessibility-controls {
    text-align: right;
    margin-bottom: 1rem;
    z-index: 1000;
    top: 0;
    position: sticky;

    button {
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
        border: 1px;
        border-radius: 5px;
        background-color: var(--primary);
        color: var(--white);
        padding: 0.375rem 0.75rem;
        padding-inline: 1rem;
        margin: auto 0.25rem;
        display: inline-flex;
        font-size: .85rem;
    }

    .font-select {
        border: 1px solid #0000;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: var(--dark-alt);
        vertical-align: middle;
        width: clamp(3rem,20rem,100%);
        height: calc(.25rem*10);
        text-overflow: ellipsis;
        box-shadow: 0 1px color-mix(in oklab,var(--input-color)calc(var(--depth)*10%),#0000) inset,0 -1px oklch(100% 0 0/calc(var(--depth)*.1)) inset;
        border-color: var(--white);
        --input-color: color-mix(in srgb,var(--light-alt)20%,#0000);
        --size: calc(var(--size-field,.25rem)*10);
        background-image: linear-gradient(45deg,#0000 50%,currentColor 50%),linear-gradient(135deg,currentColor 50%,#0000 50%);
        background-position: calc(100% - 20px) calc(1px + 50%),calc(100% - 16.1px) calc(1px + 50%);
        background-repeat: no-repeat;
        background-size: 4px 4px,4px 4px;
        border-start-start-radius: var(--join-ss, .25rem);
        border-start-end-radius: var(--join-se, .25rem);
        border-end-end-radius: var(--join-ee, .25rem);
        border-end-start-radius: var(--join-es, .25rem);
        flex-shrink: 1;
        align-items: center;
        gap: .375rem;
        padding-inline: 1rem 1.75rem;
        font-size: .875rem;
        display: inline-flex;
        position: relative;
        margin-left: 5px;
    }
}

</style>