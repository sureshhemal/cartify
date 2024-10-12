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
          :src="product.avatar"
          alt=""
        >
      </div>
    </TableData>

    <TableData class="text-center">
      {{ product.quantity }}
    </TableData>

    <TableData class="text-right">
      <div class="flex justify-end space-x-6 w-full">
        <EyeIcon
          v-if="hasPermissionTo('update-product')"
          v-tooltip="'Show'"
          class="size-5 cursor-pointer"
          @click="$emit('show-product', product)"
        />

        <PencilIcon
          v-if="hasPermissionTo('update-product')"
          v-tooltip="'Edit'"
          class="size-5 cursor-pointer"
          @click="$emit('edit-product', product)"
        />

        <TrashIcon
          v-if="
            hasPermissionTo('delete-product') 
              && (hasPermissionAs(['ADMIN', 'SUPER_ADMIN']) || product.seller_id === authUser.id)
          "
          v-tooltip="'Delete'"
          class="text-red-500 hover:text-red-700 size-5 cursor-pointer"
          @click="$emit('delete-product', product)"
        />
      </div>
    </TableData>
  </tr>
</template>

<script>
import TableData from '@/Components/TableData.vue'
import { MoneyHandler } from '@/Support/MoneyHandler.js'
import { Money } from '@/Support/Money.js'
import { EyeIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/solid/index.js'

export default {
  name: 'ProductsTableRow',

  components: { TableData, EyeIcon, PencilIcon, TrashIcon },

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