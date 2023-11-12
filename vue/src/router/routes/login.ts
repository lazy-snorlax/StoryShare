import { routes } from '@/utilities/routes'
import Login from '@/views/login/Login.vue'

export default routes(
    {
        template: 'app',
        restricted: false,
        guest: true
    },
    [
        {
            path: '/login',
            name: 'login',
            component: Login
        }
    ])