import { storage } from './helpers/storage'
require('bootstrap')
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + ((storage.token()) ? storage.token().token : undefined)
window.axios.defaults.baseURL = process.env.MIX_API_URL
