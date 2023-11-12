import { routes } from '@/utilities/routes'
import Dashboard from '@/views/dashboard/Dashboard.vue'

export default routes(
    {
        template: 'app',
        restricted: false,
        guest: true
    },
    [
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard
        }
    ])