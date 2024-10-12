<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline/index.js'
import { $wait } from '@meforma/vue-wait-for'

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
  <div class="my-2 px-1 text-xs dark:bg-gray-900">
    <label
      for="search"
      class="block font-medium leading-6 text-gray-900 dark:text-white"
    >Quick search</label>
    <div class="relative flex items-center">
      <input
        id="search"
        type="text"
        name="search"
        :placeholder="placeholder"
        :value="modelValue"
        class="w-full focus:border-earthy-100 focus:ring focus:ring-earthy-100 focus:ring-opacity-30 rounded-md border-earthy-100 text-xs dark:text-white dark:bg-gray-700"
        :class="{'bg-gray-100 cursor-not-allowed dark:bg-gray-500': $wait.any()}"
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