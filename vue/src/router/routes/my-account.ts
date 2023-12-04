import { routes } from '@/utilities/routes'
import MyAccount from '@/views/MyAccount.vue'
import MyAccountDetails from '../../views/MyAccountDetails.vue'
import MyAccountSecurity from '../../views/MyAccountSecurity.vue'

export default routes(
    {
        template: 'app',
        restricted: true,
        guest: false
    },
    [
        {
            path: '/my-account',
            component: MyAccount,
            children: [
                {
                    path: '/my-account',
                    name: 'my-account',
                    component: MyAccountDetails
                },
                {
                    path: 'security',
                    name: 'my-account.security',
                    component: MyAccountSecurity
                },
            ]
        }
    ])