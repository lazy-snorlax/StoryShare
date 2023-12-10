import { routes } from '@/utilities/routes'
import MyStoryList from '@/views/my-stories/MyStoryList.vue'

export default routes(
    {
        template: 'app',
        restricted: true
    },
    [
        {
            path: '/my-stories',
            name: 'my-stories',
            component: MyStoryList,
            children: 
            [

            ]
        }
    ]
)