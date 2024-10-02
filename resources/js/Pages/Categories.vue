<template>
  <AppLayout title="Categories">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Categories
      </h2>
    </template>

    <template #content>
      <SearchBar
        v-model="searchText"
        placeholder="Search category by code or name"
      />

      <CategoriesTable
        :categories="categories"
        @edit-category="editCategory"
        @add-category="addCategory"
      />
    </template>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { openDialog } from 'vue3-promise-dialog'
import { debounce } from 'lodash'
import SearchBar from '@/Components/SearchBar.vue'
import CategoriesTable from '@/Components/Categories/CategoriesTable.vue'
import CategoryForm from '@/Components/Categories/CategoryForm.vue'

export default {
  name: 'Categories',

  components: {
    CategoriesTable,
    SearchBar,
    AppLayout,
  },

  data () {
    return {
      categories: [],
      searchText: '',
    }
  },

  watch: {
    searchText: {
      handler: debounce(function() {
        this.fetchCategories(1)
      }, 500),
    },
  },

  async created () {
    await Promise.all([
      this.fetchCategories(),
    ])
  },

  methods: {
    async fetchCategories () {
      this.$wait.start('fetching-categories')

      const { data } = await $http.get('categories', {
        params: {
          search: this.searchText,
        },
      })

      this.categories = data

      this.$wait.end('fetching-categories')

      return data
    },

    async addCategory () {
      const category = {
        id: null,
        name: '',
        code: null,
      }

      const details = await openDialog(CategoryForm, { category, categories: this.categories })

      if (!details) {
        return
      }

      await this.saveCategory(details)
    },

    async editCategory (category) {
      const details = await openDialog(CategoryForm, { category, categories: this.categories })

      if (!details) {
        return
      }

      await this.saveCategory(details)
    },

    async saveCategory (category) {
      this.$wait.start('saving-category')

      const method = category.id ? 'put' : 'post'

      const url = category.id ? `categories/${category.id}` : 'categories'

      await $http[method](url, category)
        .finally(() => this.$wait.end('saving-category'))

      this.success('Category saved successfully')

      await this.fetchCategories()
    },
  },
}
</script>
