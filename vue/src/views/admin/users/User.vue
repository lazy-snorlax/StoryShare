<template>
    <Header :title="'User'" :subtitle="''" />

    <Container class="w-50 ms-auto me-auto">
        <div class="card card-md shadow-sm mb-2">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col">
                        <label class="label">
                            <span class=" label-text font-bold">Name</span>
                        </label>
                        <input type="text" class="form-control w-100" v-model="userName" />
                    </div>
                </div>
                <div class="row mb-4">        
                    <div class="col">
                        <label class="label">
                            <span class=" label-text font-bold">Email</span>
                        </label>
                        <input type="text" class="form-control w-100" v-model="userEmail" />
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <label class="label">
                            <span class=" label-text font-bold">Role</span>
                        </label>
                        <select class="form-select w-100" v-model="selectedRole">
                            <option disabled value="">Please select one</option>
                            <option>User</option>
                            <option>Admin</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="label">
                            <span class=" label-text font-bold">Status</span>
                        </label>
                        <select class="form-select w-100" v-model="selectedStatus">
                            <option disabled value="">Please select one</option>
                            <option>ENABLED</option>
                            <option>PENDING</option>
                            <option>DISABLED</option>
                        </select>
                    </div>
                </div>
                <div class="text-center mb-2">
                    <!-- <button class="btn btn-success" @click="submit">Update User Details</button> -->
                </div>
            </div>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import { useRoute, useRouter } from 'vue-router';
import { computed, onBeforeMount, ref } from 'vue';
import { useUserStore } from '../../../stores/admin/users';

const route = useRoute()
const router = useRouter()

const { getUser, updateUser } = useUserStore()
const { user } = storeToRefs(useUserStore())
const userId = computed(() => { return user.value?.id })
const userName = computed({
    get() { return user.value?.name },
    set(newVal: string) { user.value.name = newVal }
})
const userEmail = computed({
    get() { return user.value?.email },
    set(newVal: string) { user.value.email = newVal }
})
const userRole = computed({
    get() { return user.value?.role },
    set(newVal: string) { user.value.role = newVal }
})
const userStatus = computed({
    get() { return user.value?.status },
    set(newVal: string) { user.value.status = newVal }
})
const selectedRole = ref(userRole)
const selectedStatus = ref(userStatus)

onBeforeMount(async () => { await getUser(route.params.id) })
// const submit = async () => {
//     try {
//         if (!userRole.value) {
//             console.log(">>> UserRole: ", userRole.value)
//             return
//         }
//         const payload = {
//             id: userId.value,
//             name: userName.value,
//             email: userEmail.value,
//             role: userRole.value,
//             status: userStatus.value,
//         }
//         console.log(">>> Update Payload: ", payload)
//         updateUser(payload)
//     } catch (error) {
//         console.log(">>>> Errors: ", error)
//     }
// }

</script>

<style lang="scss" scoped>
.card {
    background-color: var(--dark);
    color: var(--light-alt);

    .form-control, .form-select {
        background-color: var(--dark);
        color: var(--white);
        border-color: var(--grey);
    }
}

</style>