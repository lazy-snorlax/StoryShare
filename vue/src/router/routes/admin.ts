import { routes } from '@/utilities/routes'
import AdminDashboard from '@/views/admin/AdminDashboard.vue'

export default routes(
    {
        template: 'admin',
        restricted: true,
        authenticate: true,
        roles: ['admin'],
    },
    [
        {
            path: '/admin',
            name: 'admin.dashboard',
            component: AdminDashboard
        }
    ])