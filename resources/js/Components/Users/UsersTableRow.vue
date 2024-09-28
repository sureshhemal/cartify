<template>
  <tr>
    <TableData>
      <div class="flex items-center">
        <div class="h-11 w-11 flex-shrink-0">
          <img
            class="h-11 w-11 rounded-full"
            :src="user.profile_photo_url"
            alt=""
          >
        </div>
        <div class="ml-4">
          <div class="font-medium text-gray-900">
            {{ user.name }}
          </div>
          <div class="mt-1 text-gray-500">
            {{ user.email }}
          </div>
        </div>
      </div>
    </TableData>
    
    <TableData>
      <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
    </TableData>
    
    <TableData>
      {{ assignedRoles }}
    </TableData>
    
    <TableData>
      <span
        class="text-earthy-300 hover:text-earthy-500 cursor-pointer"
        @click="$emit('edit-user', user)"
      >Edit<span class="sr-only">, {{ user.name }}</span></span>
    </TableData>
  </tr>
</template>

<script>
import TableData from '@/Components/TableData.vue'

export default {
  name: 'UsersTableRow',

  components: {
    TableData,
  },

  props: {
    user: {
      type: Object,
      required: true,
    },
  },

  computed: {
    assignedRoles() {
      return this.user.roles.map(role => role.name).join(', ')
    },
  },
}
</script>