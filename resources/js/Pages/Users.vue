<template>
  <AppLayout title="Users">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Users
      </h2>
    </template>

    <template #content>
      <SearchBar
        v-model="searchText"
        placeholder="Search user by name or email"
      />

      <UsersTable
        :users="users"
        @edit-user="editUser"
        @add-user="addUser"
      />

      <PaginationBar
        :pagination-details="paginationDetails"
        @change-page="fetchUsers"
        @change-per-page="fetchUsers(1, $event)"
      />
    </template>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import UsersTable from '@/Components/Users/UsersTable.vue'
import { openDialog } from 'vue3-promise-dialog'
import UserForm from '@/Components/Users/UserForm.vue'
import PaginationBar from '@/Components/PaginationBar.vue'
import { debounce, omit } from 'lodash'
import SearchBar from '@/Components/SearchBar.vue'

export default {
  name: 'Users',

  components: {
    SearchBar,
    PaginationBar,
    AppLayout,
    UsersTable,
  },

  data () {
    return {
      users: [],
      roles: [],
      searchText: '',
      perPage: 20,
      currentPage: 1,
      paginationDetails: {},
    }
  },

  watch: {
    searchText: {
      handler: debounce(function() {
        this.fetchUsers(1)
      }, 500),
    },
  },

  async created () {
    await Promise.all([
      this.fetchUsers(),
      this.fetchRoles(),
    ])
  },

  methods: {
    async fetchUsers (page = null, perPage = null) {
      this.$wait.start('fetching-users')

      const { data } = await $http.get('users', {
        params: {
          page: page ?? this.currentPage,
          per_page: perPage ?? this.perPage,
          search: this.searchText,
        },
      })

      this.users = data.data

      this.currentPage = data.current_page
      this.perPage = data.per_page
      this.paginationDetails = omit(data, 'data')

      this.$wait.end('fetching-users')

      return data
    },

    async fetchRoles () {
      this.$wait.start('fetching-roles')

      const { data } = await $http.get('roles')

      this.roles = data

      this.$wait.end('fetching-roles')

      return data
    },

    async addUser () {
      const newUser = {
        id: null,
        name: '',
        email: null,
        roles: [],
      }

      const details = await openDialog(UserForm, { user: newUser, roles: this.roles })

      if (!details) {
        return
      }

      await this.saveUser(details)
    },


    async editUser (user) {
      const details = await openDialog(UserForm, { user, roles: this.roles })

      if (!details) {
        return
      }

      await this.saveUser(details)
    },

    async saveUser (user) {
      this.$wait.start('saving-user')

      const method = user.id ? 'put' : 'post'

      const url = user.id ? `users/${user.id}` : 'users'

      await $http[method](url, user)
        .finally(() => this.$wait.end('saving-user'))

      this.success('User saved successfully')

      await this.fetchUsers()
    },
  },
}
</script>
