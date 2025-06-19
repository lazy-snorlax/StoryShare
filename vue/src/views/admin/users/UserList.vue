<template>
    <Header :title="'Users'" :subtitle="''" />

    <Container class="ms-auto me-auto">
        <div class="card mb-2">
            <div class="card-body row">
                <h5 class="card-title col">NAME</h5>
                <h5 class="card-title col">EMAIL</h5>
                <h5 class="card-title col">ROLE</h5>
                <h5 class="card-title col">STATUS</h5>
            </div>
            <template v-for="user in list">
                <router-link :to="{ name: 'admin.users.single', params: { id: user.id }}">
                    <div class="card-body row listitem">
                        <div class="card-title col">{{ user.name }}</div>
                        <div class="card-title col">{{ user.email }}</div>
                        <div class="card-title col">{{ user.role }}</div>
                        <div class="card-title col">{{ user.status.toUpperCase() }}</div>
                    </div>
                </router-link>
            </template>
        </div>
    </Container>
</template>

<script lang="ts" setup>

import { storeToRefs } from 'pinia';
import { onBeforeMount } from 'vue';
import { useUserStore } from '../../../stores/admin/users';

const { list } = storeToRefs(useUserStore())
const { getUsers } = useUserStore()

onBeforeMount(async () => {
    await getUsers()
})

</script>

<style lang="scss" scoped>
.card {
    background-color: var(--dark);
    color: var(--light-alt);

    a {
        text-decoration: none;
        color: var(--light-alt);
        &:hover {
            background-color: var(--light-alt);
            color: var(--black);
        }
    }
}

</style>