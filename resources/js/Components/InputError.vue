<script setup>
defineProps({
  message: String,
})
</script>

<template>
  <div v-show="message">
    <p class="text-xs text-red-600 pt-0.5">
      {{ message }}
    </p>
  </div>
</template>
