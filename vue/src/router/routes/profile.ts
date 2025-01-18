import { routes } from '@/utilities/routes'
import Profile from '../../views/Profile.vue'

export default routes(
    {
        template: 'app',
        restricted: false,
        authenticate: false
    },
    [
        {
            path: '/profile',
            children:
            [
                {
                    path: '/profile/:id',
                    name: 'profile',
                    component: Profile
                },
            ]
        }
    ])