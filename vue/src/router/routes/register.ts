import { routes } from '@/utilities/routes'
import RegisterAccount from '@/views/register/RegisterAccount.vue'
import RegisterVerification from '@/views/register/RegisterVerification.vue'

export default routes(
    {
        template: 'auth',
        restricted: false,
        guest: true
    },
    [
        {
            path: '/register',
            name: 'register.account',
            component: RegisterAccount,
            meta: {
                authenticate: false
            }
        },
        {
            path: '/verification/:signature?',
            name: 'register.verification',
            component: RegisterVerification,
            meta: {
                authenticate: false
            }
        },
    ])