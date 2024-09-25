<template>
  <GuestLayout title="Home">
    <HeroSection />

    <CategorySection />

    <FeaturedSection />

    <FavouritesSection />

    <CTASection />
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import CategorySection from '@/Pages/Home/CategorySection.vue'
import FeaturedSection from '@/Pages/Home/FeaturedSection.vue'
import FavouritesSection from '@/Pages/Home/FavouritesSection.vue'
import CTASection from '@/Pages/Home/CTASection.vue'
import HeroSection from '@/Pages/Home/HeroSection.vue'
import { Head } from '@inertiajs/vue3'
</script>