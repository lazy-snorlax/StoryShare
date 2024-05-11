import { useAuthStore } from "../../stores/auth";
import type { Router } from "vue-router";

export default (router: Router) => 
    router.beforeEach(async (to) => {
        const authStore = useAuthStore()

        try {
            if (authStore.user === null) {
                if (authStore.authenticationAttempted) {
                    throw new Error('Authentication has already been attempted.')
                }

                await authStore.getUser()
            }
        } catch {
            // If route is restricted, redirect to dashboard
            // console.log('>>> Route Redirect ', to.meta.restricted)
            if (to.meta.restricted !== false) {
                return {
                    name: 'dashboard',
                    replace: true,
                    query: {
                        redirect: to.path
                    }
                }
            }
        }
        
        // Public facing routes
        if (to.meta.authenticate === false) {
            return true
        }

    })