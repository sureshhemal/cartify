import axios from 'axios'

window.$http = axios

window.$http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.$http.defaults.baseURL = 'api/'