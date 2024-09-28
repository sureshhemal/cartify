<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { flatten } from 'lodash'

const TEXT_COLOR_MAP = {
  earthy: ['text-white'],
  cosmic: ['text-gray-700 hover:text-white'],
  clean: ['text-gray-700 hover:text-white'],
}

const colorProfile = computed(() => {
  return usePage().props.auth.user?.color_profile || 'earthy'
})

const props = defineProps({
  disabled: {
    type: Boolean,
    default: () => false,
  },

  errorBag: {
    type: Object,
    default: () => null,
  },
})

/**
 * Use this for dynamic color profiles
 */
const themeClass = computed(() => {
  return `bg-${colorProfile.value}-100 hover:bg-${colorProfile.value}-400 ${TEXT_COLOR_MAP[colorProfile.value]}`
})

const errorMessageTooltip = computed(() => {
  if(!props.errorBag) {
    return
  }

  return flatten(Object.values(props.errorBag)).join('<br/>')
})

const isDisabled = computed(() => {
  if(!props.errorBag) {
    return props.disabled
  }

  return props.disabled || Object.keys(props.errorBag).length
})
</script>

<template>
  <button
    v-tooltip="{html: true, content: errorMessageTooltip}"
    :disabled="isDisabled"
    class="inline-block rounded-md border border-transparent px-4 py-1.5 text-center font-medium bg-earthy-100 text-white"
    :class="[isDisabled ? 'cursor-not-allowed bg-earthy-100' : 'cursor-pointer hover:bg-earthy-400']"
  >
    <slot />
  </button>
</template>

<style scoped>

</style>