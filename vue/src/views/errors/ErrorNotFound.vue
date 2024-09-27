<template>
    <div class="card card-authentication">
        <div class="card-body p-5">
            <h1>Sorry this page could not be found.</h1>
            <p>The link you are trying to access is broken or has been moved. Click below to proceed to the dashboard.</p>

            <router-link class="button" :to="{ name: 'dashboard' }">
                Return to Dashboard
            </router-link>

        </div>
    </div>
</template>

<script>


</script>