import { routes } from '@/utilities/routes'
import MyStoryList from '../../views/my-stories/MyStoryList.vue'
import MyStorySingle from '../../views/my-stories/MyStorySingle.vue'
import MyStoryChapter from '../../views/my-stories/MyStoryChapter.vue'
import MyStoryAllChapters from '../../views/my-stories/MyStoryAllChapters.vue'

export default routes(
    {
        template: 'app',
        restricted: true
    },
    [
        {
            path: '/my-stories',
            children: 
            [
                {
                    path: '/my-stories',
                    name: 'my-stories',
                    component: MyStoryList,
                },
                {
                    path: '/my-stories/:id',
                    name: 'my-stories.single',
                    component: MyStorySingle,
                },
                {
                    path: '/my-stories/:id/chapter/:chapter?',
                    name: 'my-stories.chapter.single',
                    component: MyStoryChapter,
                },
                {
                    path: '/my-stories/:id/chapters',
                    name: 'my-stories.chapter.all',
                    component: MyStoryAllChapters,
                },
            ]
        }
    ]
)