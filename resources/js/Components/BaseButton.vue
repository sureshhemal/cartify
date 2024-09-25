<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const TEXT_COLOR_MAP = {
  earthy: ['text-white'],
  cosmic: ['text-gray-700 hover:text-white'],
  clean: ['text-gray-700 hover:text-white'],
}

const colorProfile = computed(() => {
  return usePage().props.auth.user?.color_profile || 'earthy'
})

/**
 * Use this for dynamic color profiles
 */
const themeClass = computed(() => {
  return `bg-${colorProfile.value}-100 hover:bg-${colorProfile.value}-400 ${TEXT_COLOR_MAP[colorProfile.value]}`
})

</script>

<template>
  <button
    class="inline-block rounded-md border border-transparent px-8 py-3 text-center font-medium bg-earthy-100 hover:bg-earthy-400 text-white"
  >
    <slot />
  </button>
</template>

<style scoped>

</style>