import { routes } from '@/utilities/routes'
import StorySearch from '../../views/stories/StorySearch.vue'
import StorySingle from '../../views/stories/StorySingle.vue'

export default routes(
    {
        template: 'app',
        restricted: false
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
                },
                {
                    path: '/story/:id',
                    name: 'story.single',
                    component: StorySingle,
                    children:
                    [
                        {
                            path: '/stories/:id/chapter/all',
                            name: 'story.chapter.all',
                        },
                        {
                            path: '/stories/:id/chapter/:chapter',
                            name: 'story.chapter.single',
                        },
                    ]
                },
            ]
        }
    ]
)