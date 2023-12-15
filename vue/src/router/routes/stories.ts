import { routes } from '@/utilities/routes'
import StorySearch from '../../views/stories/StorySearch.vue'
import StorySingle from '../../views/stories/StorySingle.vue'
import StoryChapter from '../../views/stories/StoryChapter.vue'
import StoryAllChapters from '../../views/stories/StoryAllChapters.vue'

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
                },
                {
                    path: '/story/:id/chapter/:chapter?',
                    name: 'story.chapter.single',
                    component: StoryChapter
                },
                {
                    path: '/story/:id/chapters',
                    name: 'story.chapter.all',
                    component: StoryAllChapters
                },
            ]
        }
    ]
)