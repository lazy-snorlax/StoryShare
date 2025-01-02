import type { App } from "vue";
import Header from './app/Header.vue';
import Container from "./app/Container.vue";
import Sidebar from './app/Sidebar.vue';
import AdminHeader from "./admin/AdminHeader.vue";
import AdminSidebar from "./admin/AdminSidebar.vue";

export const components = {
    install(app: App) {
        app.component('Header', Header)
        app.component('Container', Container)
        app.component('Sidebar', Sidebar)

        app.component('AdminHeader', AdminHeader)
        app.component('AdminSidebar', AdminSidebar)
    }
}