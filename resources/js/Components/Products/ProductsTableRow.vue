<template>
  <tr>
    <TableData>{{ product.name }}</TableData>

    <TableData class="text-right">
      {{ productPrice }}
    </TableData>

    <TableData class="flex items-center justify-center">
      <div class="h-11 w-11 flex-shrink-0">
        <img
          class="h-11 w-11 rounded-full"
          :src="product.image_url"
          alt=""
        >
      </div>
    </TableData>

    <TableData class="text-center">
      {{ product.quantity }}
    </TableData>

    <TableData class="text-center">
      <span
        v-if="hasPermissionTo('update-product')"
        class="text-earthy-300 hover:text-earthy-500 cursor-pointer"
        @click="$emit('edit-product', product)"
      >Edit<span class="sr-only">, {{ product.name }}</span></span>
    </TableData>
  </tr>
</template>

<script>
import TableData from '@/Components/TableData.vue'
import { MoneyHandler } from '@/Support/MoneyHandler.js'
import { Money } from '@/Support/Money.js'

export default {
  name: 'ProductsTableRow',

  components: { TableData },

  props: {
    product: {
      type: Object,
      required: true,
    },
  },

  computed: {
    productPrice() {
      const price = new Money(this.product.price.amount, this.product.price.currency)

      return (new MoneyHandler(price)).format()
    },
  },
}
</script>