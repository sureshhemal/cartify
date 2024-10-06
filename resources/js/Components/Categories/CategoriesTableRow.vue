<template>
  <tr>
    <TableData>{{ category.code }}</TableData>
    
    <TableData>{{ category.name }}</TableData>

    <TableData>
      <span
        v-if="hasPermissionTo('update-category')"
        class="text-earthy-300 hover:text-earthy-500 cursor-pointer"
        @click="$emit('edit-category', category)"
      >Edit<span class="sr-only">, {{ category.name }}</span></span>
    </TableData>
  </tr>
</template>

<script>
import TableData from '@/Components/TableData.vue'

export default {
  name: 'CategoriesTableRow',

  components: {
    TableData,
  },

  props: {
    category: {
      type: Object,
      required: true,
    },
  },
}
</script>