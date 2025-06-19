import { routes } from '@/utilities/routes'
import AdminDashboard from '../../views/admin/AdminDashboard.vue'
import UserList from '../../views/admin/users/UserList.vue'
import User from '../../views/admin/users/User.vue'

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
            children: [
                {
                    path: '',
                    name: 'admin.dashboard',
                    component: AdminDashboard,
                },
                {
                    path: 'users',
                    name: 'admin.users.list',
                    component: UserList
                },
                {
                    path: 'users/:id',
                    name: 'admin.users.single',
                    component: User
                },
            ]
        },
    ]
)