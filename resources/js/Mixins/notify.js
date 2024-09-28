import { push } from 'notivue'

export default {
  methods: {
    success(message, title = 'Success') {
      push.success({ title, message })
    },

    warning(message, title = 'Warning') {
      push.warning({ title, message })
    },

    error(message, title = 'Oops...') {
      push.error({ title, message })
    },
  },
}