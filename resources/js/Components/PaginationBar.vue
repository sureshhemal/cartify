<template>
  <div class="flex justify-between my-4 mx-2 items-center">
    <div class="flex items-center space-x-2">
      <label class="text-xs dark:text-white">Per Page</label>
      <BaseInput
        v-model="perPage"
        name="perPage"
        type="number"
        :disabled="$wait.any()"
      />
    </div>
    <div class="text-xs dark:text-white">
      {{ currentResultRangeSummary }}
    </div>
    <div>
      <div
        v-if="!!paginationDetails.links && paginationDetails.links.length > 3"
        class="flex justify-center space-x-2"
      >
        <div
          v-for="(link, k) in paginationDetails.links"
          :key="k"
          class="px-4 py-1.5 text-sm leading-4 rounded cursor-pointer hover:shadow"
          :class="{
            'bg-earthy-300 text-white': link.active,
            'cursor-not-allowed': !link.url,
            'bg-white': !link.active
          }"
          @click="handleChangePage(link)"
          v-html="link.label"
        />
      </div>
    </div>
  </div>
</template>

<script>
import BaseInput from './BaseInput.vue'
import { debounce } from 'lodash'

export default {
  name: 'PaginationBar',
  components: { BaseInput },

  props: {
    paginationDetails: {
      type: Object,
      default: () => {},
    },
  },

  emits: ['change-page', 'change-per-page'],

  computed: {
    currentResultRangeSummary() {
      return `showing ${this.paginationDetails.from} - ${this.paginationDetails.to} of ${this.paginationDetails.total} results`
    },

    perPage: {
      get() {
        return this.paginationDetails.per_page
      },

      set: debounce(function (value) {
        if (!parseInt(value) || parseInt(value) < 10) {
          return
        }

        this.$emit('change-per-page', parseInt(value > 200 ? 200 : value))
      }, 500),
    },
  },

  methods: {
    handleChangePage(link) {
      if (link.active || !link.url) {
        return
      }

      this.$emit('change-page', link.url.split('?page=')[1])
    },
  },
}
</script>
