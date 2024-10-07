<template>
  <AppLayout title="Categories">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Products
      </h2>
    </template>

    <template #content>
      <SearchBar
        v-model="searchText"
        placeholder="Search product by code, name or description"
      />

      <ProductsTable
        :products="products"
        @show-product="showProduct"
        @add-product="addProduct"
        @edit-product="editProduct"
        @delete-product="deleteProduct"
      />

      <PaginationBar
        :pagination-details="paginationDetails"
        @change-page="fetchProducts"
        @change-per-page="fetchProducts(1, $event)"
      />
    </template>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { openDialog } from 'vue3-promise-dialog'
import { debounce, omit } from 'lodash'
import SearchBar from '@/Components/SearchBar.vue'
import ProductsTable from '@/Components/Products/ProductsTable.vue'
import PaginationBar from '@/Components/PaginationBar.vue'
import ProductForm from '@/Components/Products/ProductForm.vue'
import ConfirmDialog from '@/Components/ConfirmDialog.vue'
import ProductPreview from '@/Components/Products/ProductPreview.vue'

export default {
  name: 'Products',

  components: {
    PaginationBar,
    ProductsTable,
    SearchBar,
    AppLayout,
  },

  data () {
    return {
      products: [],
      categories: [],
      sellers: [],
      searchText: '',
      paginationDetails: {},
    }
  },

  watch: {
    searchText: {
      handler: debounce(function() {
        this.fetchProducts(1)
      }, 500),
    },
  },

  async created () {
    await Promise.all([
      this.fetchProducts(),
      this.fetchCategories(),
      this.fetchSellers(),
    ])
  },

  methods: {
    async fetchProducts (page = null, perPage = null) {
      this.$wait.start('fetching-products')

      const { data } = await $http.get('products', {
        params: {
          page: page ?? this.currentPage,
          per_page: perPage ?? this.perPage,
          search: this.searchText,
        },
      })

      this.products = data.data

      this.currentPage = data.current_page
      this.perPage = data.per_page
      this.paginationDetails = omit(data, 'data')

      this.$wait.end('fetching-products')

      return data
    },

    async fetchCategories () {
      this.$wait.start('fetching-categories')

      const { data } = await $http.get('categories')

      this.categories = data

      this.$wait.end('fetching-categories')

      return data
    },
    
    async fetchSellers() {
      this.$wait.start('fetching-sellers')
      
      const { data } = await $http.get('users', {
        params: {
          role: 'SELLER',
        },
      })
      
      this.sellers = data
      
      this.$wait.end('fetching-sellers')
      
      return data
    },

    async showProduct(product) {
      await openDialog(ProductPreview, {
        product,
      })
    },

    async addProduct () {
      const product = {
        id: null,
        category_id: '',
        seller_id: this.loggedInAs('SELLER') ? this.authUser.id : null,
        code: '',
        name: '',
        description: '',
        quantity: '',
        price: {
          amount: '',
          currency: 'LKR',
        },
        media: {
          saved: [],
          added: [],
          removed: [],
        },
      }

      const details = await openDialog(ProductForm, {
        product,
        categories: this.categories,
        sellers: this.sellers,
      })

      if (!details) {
        return
      }

      await this.saveProduct(details)
    },

    async deleteProduct(product) {
      const confirm = await openDialog(ConfirmDialog, {
        title: product.name,
        text: 'Are your sure to delete this product?',
      })

      if(!confirm) {
        return
      }

      this.$wait.start('deleting-product')
      
      await $http.delete(`products/${product.id}`)
        .finally(() => this.$wait.end('deleting-product'))

      return await this.fetchProducts()
    },

    async editProduct (product) {
      const details = await openDialog(ProductForm, {
        product: {
          ...product,
          media: {
            saved: product.media,
            added: [],
            removed: [],
          },
        },
        categories: this.categories,
        sellers: this.sellers,
      })

      if (!details) {
        return
      }

      await this.saveProduct(details)
    },

    async saveProduct (product) {
      this.$wait.start('saving-product')

      const method = product.id ? 'put' : 'post'

      const url = product.id ? `products/${product.id}` : 'products'

      await $http[method](url, product)
        .finally(() => this.$wait.end('saving-product'))

      this.success('Product saved successfully')

      await this.fetchProducts()
    },
  },
}
</script>
