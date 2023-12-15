<template>
    <Container class="container-max-sm mx-auto p-4">
        <div class="my-account card">
            <div class="card-body">
                <div class="mx-auto">
                    <h2>Details</h2>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" v-bind="name">
                        <small class="text-danger">{{ errors.name }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" v-bind="email">
                        <small class="text-danger">{{ errors.email }}</small>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button class="btn btn-primary" @click="save">Save</button>
                    </div>
                </div>
            </div>
        </div>        
    </Container>
</template>
<script lang="ts" setup>

import { useForm } from 'vee-validate';
import { useLoggedInUser } from '../../composables/use-logged-in-user';
import { object, string } from 'yup';
import { useAuthStore, type UpdateAccountDetailsForm } from '../../stores/auth'

const { loggedInUser } = useLoggedInUser()
const { updateAccountDetails } = useAuthStore()

const {  defineInputBinds, handleSubmit, errors } = useForm<UpdateAccountDetailsForm>({
    validationSchema: object({
        name: string().required(),
        email: string().email().required(),
    }),
    initialValues: {
        name: loggedInUser.value.name,
        email: loggedInUser.value.email,
    }
})

const name = defineInputBinds('name')
const email =  defineInputBinds('email')

const save = handleSubmit(async (values) => {
    await updateAccountDetails(values)

    if (loggedInUser.value.new_email) {
        // TODO: New email verification
        console.log('New email detected')
    } else {
        console.log('Account Details saved successsfully')
    }

})

</script>