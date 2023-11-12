import { createApp } from 'vue'
import { pinia } from '@/stores'
import { components } from './components'

import App from './App.vue'
import router from './router'
import http from './utilities/http'

import './assets/main.css'
import '@fortawesome/fontawesome-free'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'

const app = createApp(App)

app.use(http, { router })
app.use(pinia)
app.use(router)
app.use(components)

app.mount('#app')
