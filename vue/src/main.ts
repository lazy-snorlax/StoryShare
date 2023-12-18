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

// Vue MultiSelect library
import 'vue-multiselect/dist/vue-multiselect.css'
import MultiSelect from 'vue-multiselect'

import 'vue-final-modal/style.css'
import { createVfm } from 'vue-final-modal'
const vfm = createVfm()

const app = createApp(App)

app.use(http, { router })
app.use(pinia)
app.use(router)
app.use(components)
app.use(vfm)

// Font Awesome Icons
app.component('font-awesome-icon', FontAwesomeIcon)

// Utility Components
app.component('multi-select', MultiSelect)

app.mount('#app')
