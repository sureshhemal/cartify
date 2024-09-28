<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Components/Welcome.vue'
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      Dashboard
    </template>

    <template #content>
      <Welcome />
    </template>
  </AppLayout>
</template>
