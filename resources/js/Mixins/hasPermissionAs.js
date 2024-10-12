import { isArray, map } from 'lodash'
import { usePage } from '@inertiajs/vue3'

export default {
  computed: {
    authUser() {
      return usePage().props.auth.user
    },

    authUserPermissions() {
      const rolePermissions = map(this.authUser.roles.flatMap(role => role.permissions), 'name')

      const directPermissions = map(this.authUser.permissions, 'name')

      return [...rolePermissions, ...directPermissions]
    },
  },

  methods: {
    hasPermissionTo(permission) {
      permission = isArray(permission) ? permission : [permission]

      return permission.some(per => this.authUserPermissions.includes(per))
    },

    hasPermissionAs(roles) {
      roles = isArray(roles) ? roles : [roles]

      return this.authUser.roles.some(role => roles.includes(role.name))
    },

    loggedInAs(role) {
      return this.authUser.roles.length === 1 &&
        this.hasPermissionAs(role)
    },
  },
}