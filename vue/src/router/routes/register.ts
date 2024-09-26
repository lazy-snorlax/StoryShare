import { routes } from '@/utilities/routes'
import RegisterAccount from '@/views/register/RegisterAccount.vue'
import RegisterVerification from '@/views/register/RegisterVerification.vue'
import RegisterComplete from '@/views/register/RegisterComplete.vue'

export default [
    ...routes(
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
                path: '/register/verification/:signature?',
                name: 'register.verification',
                component: RegisterVerification,
                meta: {
                    authenticate: false
                }
            },
            {
                path: '/register/complete',
                name: 'register.complete',
                component: RegisterComplete,
                meta: {
                    authenticate: false
                }
            },
        ]
    )
]