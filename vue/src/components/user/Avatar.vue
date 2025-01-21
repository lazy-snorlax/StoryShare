<template>
  <div class="avatar" :class="classNames">
    <img
      v-if="avatar"
      :src="avatar"
      width="256"
      height="256"
      :alt="name"
    />
    <div v-else>
      {{ initials }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, onBeforeMount, reactive, watchEffect } from 'vue'

const props = defineProps({
  name: String || null,
  avatar: String,
  country: String,
  current_season_status: String,
  in_off_season: Boolean,
  size: {
    type: String,
    default: 'm'
  }
})

const classNames = computed(() => {
  return [
    `avatar-${props.size}`,
    {
      'avatar-empty': !props.avatar,
      ending: props.current_season_status === 'ending',
      ended: props.current_season_status === 'ended' || props.in_off_season
    }
  ]
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
