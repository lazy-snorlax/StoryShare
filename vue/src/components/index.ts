import type { App } from "vue";
import Header from './app/Header.vue';
import Container from "./app/Container.vue";
import Sidebar from './app/Sidebar.vue';

export const components = {
    install(app: App) {
        app.component('Header', Header)
        app.component('Container', Container)
        app.component('Sidebar', Sidebar)
    }
}