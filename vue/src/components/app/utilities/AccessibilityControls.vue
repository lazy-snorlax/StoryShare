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
        <select class="" @change="changeFont">
            <option v-for="font in fontOptions" :value="font">{{ font }}</option>
        </select>
    </div>
</template>

<script setup lang="ts">
    import MultiSelect from './MultiSelect.vue'

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
        margin: auto 2px;
        display: inline-flex;
        font-size: .85rem;
    }
}

</style>