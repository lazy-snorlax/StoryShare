<template>

    <Header title="Chapter Template" />

    <template v-for="chapter in chapters">
        <li>
            <p>{{ chapter }}</p>
        </li>
    </template>

</template>
<script lang="ts" setup>

const chapters = [ 1, 2, 3 ]

</script>