<template>
  <div class="avatar" >
    <img
      v-if="imgSrc != null"
      :src="imgSrc"
      :width="imgSize"
      :height="imgSize"
      :alt="name"
    />
    <div v-else>
      {{ initials }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({
  name: String || null,
  imgSrc: String || null || undefined,
  imgSize: {
    type: Number,
    default: 200,
  },
  size: {
    type: String,
    default: 'm'
  }
})

const initials = computed(() => {
  if (!props.name) { return null }

  const [firstName, lastName] = props.name.split(' ')
  if (firstName && lastName) {
    return `${firstName.charAt(0)}${lastName.charAt(0)}`
  }
  return firstName.substring(0, 2)
})

</script>
