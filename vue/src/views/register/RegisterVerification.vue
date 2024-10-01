<template>
    <div class="card card-authentication">
        <div class="card-body p-5">
            <template v-if="verifying">
                <h1>Please wait, verifying your account</h1>
            </template>
            <template v-else-if="passedVerification">
                <h1>
                    <font-awesome-icon icon="fa-solid fa-user-shield" />
                    Thank you for verifying your account.
                </h1>
                <!-- Set up 2FA Here -->
            </template>
            <template v-else>
                <h1>Verify Account</h1>
                <p>
                    An email has been sent to <strong>{{ email }}</strong> with a link to verify your account.
                    Please check your inbox and verify your address before continuing with account setup.
                </p>
                <div class="row text-info-emphasis mb-4">
                    <div class="col-auto d-flex align-items-center bg-dark-subtle p-3 rounded">
                        <font-awesome-icon icon="fa-solid fa-circle-info"></font-awesome-icon>
                        <div class="col ms-3">
                            <p class="small mb-0">
                                If you don't see the verification email in your inbox, check your junk folder or request the email to be re-sent by clicking the button below.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col d-flex align-items-center">
                        <button type="button" class="btn btn-info" @click="resend">Re-send Email</button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary" @click="verify">
                        I Have Verified My Account
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
    
</template>
<script lang="ts" setup>
import { computed, onMounted, ref } from 'vue';
import { useIsLoggedIn } from '@/composables/use-is-logged-in'
import { useLogout } from '@/composables/use-logout'
import { useRoute, useRouter } from 'vue-router';
import { isAxiosError } from 'axios';
import { http } from '../../utilities/http';

const { getLoggedInUser } = useIsLoggedIn()
const { logout } = useLogout()
const route = useRoute()
const router = useRouter()

const email = computed(() => route.query.email)
const verifying = ref(route.params.signature !== undefined)
const failedVerification = ref(false)
const passedVerification = ref(false)

onMounted(async () => {
    console.log('>>>> http', http)
    if (verifying.value) {
        try {
            await http.post('register/verification', {
                signature: route.params.signature,
                email: route.query.email,
                expires: route.query.expires,
                id: route.query.id
            })

            // await getLoggedInUser()
            passedVerification.value = true
            const redirect = 
                route.name !== 'login' &&
                route.name !== 'logout' &&
                route.name !== null &&
                route.meta.restricted === true ? route.path : null
            router.replace({ name: 'register.complete', query: { redirect } })

        } catch (error) {
            console.log('>>>> Testing onMounted: ', error)
            if ((await emailAlreadyVerified(error)) === false) {
                failedVerification.value = true
            }
        } finally {
            verifying.value = false
        }
    }
})

async function emailAlreadyVerified(error: any): Promise<boolean> {
  if (
    isAxiosError(error) &&
    error.response &&
    error.response.data.code === 'email_already_verified'
  ) {
    // If the email is already verified, alert the user and redirect them to the dashboard after getting the logged in user again.
    await getLoggedInUser()
    alert('Your email is already verified.'),
    passedVerification.value = true
    return true
  }
  return false
}

async function verify() {
  const loggedInUser = await getLoggedInUser()

  if (loggedInUser?.email_verified) {
    passedVerification.value = true
  } else {
    alert('Your account has not been verified. Please verify your account by following the instructions in the email we sent you.')
  }
}

async function resend() {
  try {
    await this.http.post('register/verification/resend')
    alert('A verification email has been sent. The link in this email is valid for 1 hour.')
  } catch (error) {
    console.log('>>>> Testing re-send', error)
    if ((await emailAlreadyVerified(error)) === false) {
      alert('Failed to send verification email. Please contact support to help with verifying your email.')
    }
  }
}

</script>