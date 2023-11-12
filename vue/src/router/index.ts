import { createRouter, createWebHistory } from 'vue-router'
import {routes as defineRoute} from '@/utilities/routes'
import routes from './routes'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    ...routes,
  ]
})


// Bind the authenticated and authorized guards to ensure users are logged in and have the correct permission.
// authenticated(router)
// authorized(router)

// Bind the other middleware to handle things such as account verification and two factor.
// middleware(router)

export default router
