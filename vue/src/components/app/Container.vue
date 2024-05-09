<template>
    <div class="layout-sidesheet row" style="width: -moz-available;">
        <div class="col main-content pb-0" :class="{ 'd-flex flex-column': mainContentFlex }">
          <slot name="beforeContainer" />

          <slot v-if="noContainer" />
          <div v-else v-bind="attrs">
              <slot />
          </div>

          <slot name="afterContainer" />
        </div>

        <slot name="sidesheet" />
    </div>
    <!-- <div v-else v-bind="attrs">
        <slot />
    </div> -->
</template>

<script lang="ts" setup>
import { useAttrs, computed } from 'vue'

const props = withDefaults(
  defineProps<{
    mainContentFlex?: boolean
    noContainer?: boolean
  }>(),
  {
    sidesheet: false,
    mainContentFlex: false,
    noContainer: false,
  }
)

const attrs = computed(() => {
  const defaultAttrs = useAttrs()

  return {
    ...defaultAttrs,
    class: [
      props.noContainer ? '' : 'container',
      defaultAttrs.class === undefined && props.sidesheet === false
        ? 'container-fluid mt-4 mb-4'
        : defaultAttrs.class,
    ],
  }
})
</script>

<script lang="ts">
export default {
  inheritAttrs: false,
}
</script>