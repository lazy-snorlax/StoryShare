import { createApp } from 'vue'
import { pinia } from '@/stores'
import { components } from './components'

import App from '../src/App.vue'
import router from './router'
import http from './utilities/http'
import FontAwesomeIcon from './utilities/fontawesome-icons'

import './assets/main.css'
import '@fortawesome/fontawesome-free'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'

const app = createApp(App)

app.use(http, { router })
app.use(pinia)
app.use(router)
app.use(components)

// Font Awesome Icons
app.component('font-awesome-icon', FontAwesomeIcon)

app.mount('#app')
