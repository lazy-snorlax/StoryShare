<template>
	<component :is="templateComponent" />
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { templates } from './templates'

window.document.title = import.meta.env.VITE_APP_TITLE

const route = useRoute()

const templateComponent = computed(() => {
	if (route.meta.template && route.meta.template in templates) {
		return templates[route.meta.template]
	}
	return templates.empty
})

</script>

<style lang="scss">
:root {
	--primary: #4ad4de;
	--primary-alt: #22a5c5;
	--grey: #64748b;
	--dark: #1e293b;
	--dark-alt: #334155;
	--light: #f1f5f9;
	--sidebar-width: 300px;
}
* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: 'Fira sans', sans-serif;
}
body {
	display: inline;
	background: var(--dark);
}
button {
	cursor: pointer;
	appearance: none;
	border: none;
	outline: none;
	background: none;
}
.app {
	display: flex;
	main {
		flex: 1 1 0;
		padding: 2rem;
		@media (max-width: 1024px) {
			padding-left: 6rem;
		}
	}
}
</style>
