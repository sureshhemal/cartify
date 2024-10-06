<template>
  <BaseTable>
    <template #title>
      Categories
    </template>
    
    <template #description>
      A list of all categories.
    </template>
    
    <template #action>
      <BaseButton
        v-if="hasPermissionTo('create-category')"
        :disabled="$wait.any()"
        @click="$emit('add-category')"
      >
        Add Category
      </BaseButton>
    </template>

    <template #table-header-row> 
      <TableHead>Code</TableHead>
      <TableHead>Name</TableHead>
      <TableHead />
    </template>

    <template #table-body>
      <tr v-if="!categories.length">
        <td
          colspan="4"
          class="text-center py-8"
        >
          -- No categories found --
        </td>
      </tr>
      <CategoriesTableRow
        v-for="category in categories"
        :key="category.id"
        :category="category"
        @edit-category="$emit('edit-category', $event)"
      />
    </template>
  </BaseTable>
</template>

<script>
import BaseTable from '@/Components/BaseTable.vue'
import BaseButton from '@/Components/BaseButton.vue'
import TableHead from '@/Components/TableHead.vue'
import CategoriesTableRow from '@/Components/Categories/CategoriesTableRow.vue'

export default {
  name: 'CategoriesTable',
  
  components: {
    CategoriesTableRow,
    BaseButton,
    BaseTable,
    TableHead,
  },
  
  props: {
    categories: {
      type: Array,
      required: true,
    },
  },
}
</script>