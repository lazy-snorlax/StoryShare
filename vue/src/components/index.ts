import type { App } from "vue";
import Header from './app/Header.vue'
import Sidebar from './app/Sidebar.vue'

export const components = {
    install(app: App) {
        app.component('Header', Header)
        app.component('Sidebar', Sidebar)
    }
}