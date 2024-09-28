<template>
  <BaseTable>
    <template #title>
      Users
    </template>
    
    <template #description>
      A list of all the users in your account including their name, title, email and role.
    </template>
    
    <template #action>
      <BaseButton
        :disabled="$wait.any()"
        @click="$emit('add-user')"
      >
        Add user
      </BaseButton>
    </template>

    <template #table-header-row> 
      <TableHead>Name</TableHead>
      <TableHead>Status</TableHead>
      <TableHead>Role</TableHead>
      <TableHead />
    </template>

    <template #table-body>
      <tr v-if="!users.length">
        <td
          colspan="4"
          class="text-center py-8"
        >
          -- No users found --
        </td>
      </tr>
      <UsersTableRow
        v-for="user in users"
        :key="user.id"
        :user="user"
        @edit-user="$emit('edit-user', $event)"
      />
    </template>
  </BaseTable>
</template>

<script>
import BaseTable from '@/Components/BaseTable.vue'
import BaseButton from '@/Components/BaseButton.vue'
import TableHead from '@/Components/TableHead.vue'
import UsersTableRow from '@/Components/Users/UsersTableRow.vue'

export default {
  name: 'UserTable',
  
  components: {
    BaseButton,
    BaseTable,
    TableHead,
    UsersTableRow,
  },
  
  props: {
    users: {
      type: Array,
      required: true,
    },
  },
}
</script>