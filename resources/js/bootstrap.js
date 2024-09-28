import axios from 'axios'
import { push } from 'notivue'

window.$http = axios

window.$http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.$http.defaults.baseURL = 'api/'

window.$http.interceptors.response.use(
  response => {
    return response
  },

  error => {
    if (error.response && [422, 403, 401, 500].includes(error.response.status)) {
      push.error({ title: 'Oops...', message: error.response.data.message })
    }

    return Promise.reject(error)
  },
)