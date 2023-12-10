import { routes } from '@/utilities/routes'
import StorySearch from '../../views/stories/StorySearch.vue'

export default routes(
    {
        template: 'app',
        restricted: true
    },
    [
        {
            path: '/stories',
            children:
            [
                {
                    path: '/stories',
                    name: 'stories',
                },
                {
                    path: '/stories/search',
                    name: 'stories.search',
                    component: StorySearch
                }
            ]
        }
    ]
)