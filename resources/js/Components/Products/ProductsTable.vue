<template>
  <BaseTable>
    <template #title>
      Products
    </template>
    
    <template #description>
      List of all products
    </template>

    <template #action>
      <BaseButton
        v-if="hasPermissionTo('create-product')"
        :disabled="$wait.any()"
        @click="$emit('add-product')"
      >
        Add Product
      </BaseButton>
    </template>

    <template #table-header-row>
      <TableHead>Name</TableHead>
      <TableHead class="text-right">
        Price
      </TableHead>
      <TableHead class="text-center">
        Image
      </TableHead>
      <TableHead class="text-center">
        Quantity
      </TableHead>
      <TableHead />
    </template>

    <template #table-body>
      <tr v-if="!products.length">
        <td
          colspan="5"
          class="text-center py-8"
        >
          -- No products found --
        </td>
      </tr>

      <ProductsTableRow
        v-for="product in products"
        :key="product.id"
        :product="product"
        @edit-product="$emit('edit-product', $event)"
        @delete-product="$emit('delete-product', $event)"
        @show-product="$emit('show-product', $event)"
      />
    </template>
  </BaseTable>
</template>

<script>
import BaseTable from '@/Components/BaseTable.vue'
import BaseButton from '@/Components/BaseButton.vue'
import TableHead from '@/Components/TableHead.vue'
import ProductsTableRow from '@/Components/Products/ProductsTableRow.vue'

export default {
  name: 'ProductsTable',

  components: {
    ProductsTableRow,
    TableHead,
    BaseButton,
    BaseTable,
  },
  
  props: {
    products: {
      type: Array,
      required: true,
    },
  },
}
</script>