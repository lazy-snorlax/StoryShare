import { useIsLoggedIn } from '@/composables/use-is-logged-in'
import { useLoggedInUser } from '@/composables/use-logged-in-user'
import type { Router, RouteMeta } from 'vue-router'

export default (router: Router) =>
    router.beforeEach(async (to, from) => {
        const { isLoggedIn } = useIsLoggedIn()

        if (isLoggedIn.value === false) {
            return to.meta.authorize !== undefined ? false : true
        }

        const { can, loggedInUser } = useLoggedInUser()
        const { authorize }: RouteMeta = to.meta

        if (to.meta?.authenticate) {
            // Perform check on admin routes
            if (loggedInUser?.value.role.name == 'admin' && to.meta?.roles?.includes('admin')) {
                return true
            } else if (loggedInUser?.value.role.name !== 'admin' && to.meta?.roles?.includes('admin')) {
                // If not an admin, re-route to user dashboard.
                alert('You are not authorized to access the page you have requested.')
                return from.name === undefined ? { name: 'dashboard' } : false
            }
        }
        
        // if (authorize === undefined) {
        //     // Requested route has no restrictions.
        //     return true
        // } else if (typeof authorize === 'function' && authorize({ can, to, from })) {
        //     // Requested route has a custom authorize function for more complex logic.
        //     return true
        // }

        // // Authorize may be an ability string or array of ability strings. If an array, so long as the
        // // user is authorized for one of the them we shall let them through.
        // if ((typeof authorize === 'string' && can(authorize)) || (Array.isArray(authorize) && authorize.some((ability) => can(ability)))
        // ) {
        //     return true
        // }

        // alert('You are not authorized to access the page you have requested.')
        // // await useAlert({
        // // icon: 'warning',
        // // title: 'Unauthorized',
        // // message: 'You are not authorized to access the page you have requested.',
        // // confirmationOnly: true,
        // // })

        // return from.name === undefined ? { name: 'dashboard' } : false

    })