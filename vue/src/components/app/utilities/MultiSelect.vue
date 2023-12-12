<template>
    <VueMultiselect v-bind="attrs">
        <template #noResult> No results found for the search query. </template>
        <template #noOptions> No options in list. </template>
        <template v-for="(ignore, name) in $slots" #[name]="data">
            <slot :name="name" v-bind="data" />
        </template>
    </VueMultiselect>
</template>

<script lang="ts" setup>
import { useAttrs, computed, toRefs } from 'vue'
import VueMultiselect from 'vue-multiselect'

const props = withDefaults(
    defineProps<{
        modelValue: unknown,
        options: any[],
        noSearching?: boolean,
        allowEmpty?: boolean,
        keepOpen?: boolean,
        valueOnly?: boolean,
        multiple?: boolean,
        taggable?: boolean,
        trackBy?: string,
        label?: string,
    }>(),
    {
        noSearching: false,
        allowEmpty: false,
        keepOpen: false,
        valueOnly: false,
        taggable: false,
        trackBy: 'value',
        label: 'label',
    }
)

const emit = defineEmits<{
  (e: 'update:modelValue', modelValue: unknown): void
}>()

const { options } = toRefs(props)

const optionsAreObjects = computed(() =>
  options.value.some((value) => typeof value === 'object')
)

const attrs = computed(() => {
  const defaultAttrs = useAttrs()

  let modelValue = props.modelValue

  /** 
   * If options are objects and the select is "value only", then we'll find the correct option to use
   * by comparing the model value with the "track by" key on each option. When the model value is
   * an array we instead filter the options down to those that are included in the model value.
   * **/
  if (optionsAreObjects.value && props.valueOnly) {
    modelValue = Array.isArray(modelValue)
      ? props.options.filter((option) =>
          (props.modelValue as any[]).includes(option[props.trackBy])
        )
      : props.options.find(
          (option) => option[props.trackBy] === props.modelValue
        )
  }

  return {
    showLabels: false,
    placeholder: null,
    multiple: props.multiple,
    searchable: props.taggable || !props.noSearching,
    allowEmpty: props.allowEmpty,
    trackBy: optionsAreObjects.value ? props.trackBy : undefined,
    label: optionsAreObjects.value ? props.label : undefined,
    closeOnSelect: !props.keepOpen,
    modelValue,
    options: props.options,
    taggable: props.taggable,
    'onUpdate:modelValue': (newModelValue: unknown) => {
      if (optionsAreObjects.value && props.valueOnly) {
        if (Array.isArray(newModelValue)) {
          // If the new model value is an array we'll map the new model value to the property we are tracking by.
          return emit(
            'update:modelValue',
            (newModelValue as { [key: string]: unknown }[]).map(
              (value) => value[props.trackBy]
            )
          )
        } else {
          // If the new model value is not an array we just grab the property we are tracking by.
          return emit(
            'update:modelValue',
            newModelValue
              ? (newModelValue as { [key: string]: unknown })[props.trackBy]
              : null
          )
        }
      }

      // If the options are not objects or we are not using "value only" then we just emit the new model value.
      emit('update:modelValue', newModelValue)
    },
    ...defaultAttrs,
  }
})
</script>