import { routes } from '@/utilities/routes'

import MyBookmarksList from '../../views/MyBookmarksList.vue'

export default routes (
    {
        template: 'app',
        restricted: true,
    },
    [
        {
            path: '/bookmarks',
            children:
            [
                {
                    path: '/my-bookmarks',
                    name: 'my-bookmarks',
                    component: MyBookmarksList
                },
            ]
        }
    ]
)