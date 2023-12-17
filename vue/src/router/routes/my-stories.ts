import { routes } from '@/utilities/routes'
import MyStoryList from '@/views/my-stories/MyStoryList.vue'
import MyStorySingle from '../../views/my-stories/MyStorySingle.vue' 

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
            ]
        }
    ]
)