import { routes } from '@/utilities/routes'
import PasswordForgot from '@/views/password/PasswordForgot.vue'
import PasswordReset from '@/views/password/PasswordReset.vue'

export default routes(
    {
        template: 'auth',
        restricted: false,
        guest: true
    },
    [
        {
            path: '/forgot-password',
            name: 'forgot-password',
            component: PasswordForgot
        },
        {
            path: '/set-password/:token',
            name: 'set-password',
            meta: {
                authenticate: false,
            },
            props: true,
            component: PasswordReset
        }
    ]
)