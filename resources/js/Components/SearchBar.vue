<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline/index.js'

defineProps({
  modelValue: {
    type: String,
    default: () => '',
  },
  
  placeholder: {
    type: String,
    default: () => 'Search...',
  },
})
</script>

<template>
  <div class="my-2 px-1">
    <label
      for="search"
      class="block text-sm font-medium leading-6 text-gray-900"
    >Quick search</label>
    <div class="relative mt-2 flex items-center">
      <input
        id="search"
        type="text"
        name="search"
        :placeholder="placeholder"
        :value="modelValue"
        class="w-full focus:border-earthy-100 focus:ring focus:ring-earthy-100 focus:ring-opacity-30 rounded-md border-earthy-100 text-sm"
        :class="{'bg-gray-100 cursor-not-allowed': disabled}"
        @input="$emit('update:modelValue', $event.target.value)"
      >
      <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
        <kbd class="inline-flex items-center rounded border border-gray-200 px-1 font-sans text-xs text-gray-400">
          <MagnifyingGlassIcon class="size-4" />
        </kbd>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>