<template>
    <Header :title="'My Stories'" />
    
    <Container class="container-max-xl mx-auto p-4" >
        <div v-for="item in list">
            <li class="story blurb group" style="">
                <div class="header">
                    <h4 class="my-3">{{ item.title }}</h4>
                    <div class="dates">
                        <p class="datetime">Created: <span>{{ item.created_at }}</span></p>
                        <p class="datetime">Updated: <span>{{ item.updated_at }}</span></p>
                    </div>
                </div>
                <div class="summary">
                    <p>{{ item.summary }}</p>
                </div>
                <div class="footer">
                    <div class="row d-flex">
                        <div class="col">
                            <p>Chapters: <span>{{ item.number_of_chapters }}</span></p>
                        </div>
                        <div class="col">
                            <p>Words: <span>{{ item.word_count }}</span></p>
                        </div>
                    </div>
                </div>
            </li>
        </div>
    </Container>
</template>
<script lang="ts" setup>
import { useMyStoryStore } from '../../stores/my-story';
import { onMounted } from 'vue';
import { useMyStoryList } from '../../composables/stories/use-get-my-story-list';

const myStoryStore = useMyStoryStore()
const { list } = useMyStoryList()

onMounted(async () => {
    await myStoryStore.getMyStoryList()
})

</script>

<style lang="scss">
li.blurb {
    list-style: none;
    border: none;
    border-radius: 5px;
    margin-bottom: 1.5rem;
    padding: 1rem 1.5rem;
    background-color: var(--dark);
    color: var(--light);
    &:hover {
        background-color: var(--dark-alt);
    }
    .header {
        .dates {
            display: flex;
            .datetime {
                margin: 0rem auto;
                margin-bottom: 1rem;
            }
        }
    }
}

</style>