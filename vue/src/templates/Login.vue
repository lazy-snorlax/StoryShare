<template>
    <div class="authentication">
        <div class="card card-authentication">
            <form class="card-body">
                <div class="logo">
                    <img :src="logoURL" alt="LOGO Here" class="logo">
                </div>
                <h1>Log In</h1>
                
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="text" class="form-control">
                    <span class="invalid-feedback"></span>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control">
                    <span class="invalid-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-auto text-right d-flex align-items-center">
                        <a href="/forgot-password" class="small text-muted">Forgot Password?</a>
                    </div>
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary">
                            <!-- <span class="spinner spinner-border"></span> -->
                            <span class="label"> Log In </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
    import logoURL from '../assets/logo.svg'
</script>

<style>
.authentication {
    display:flex;
    flex:1 0 auto;
    align-items:center;
    justify-content:center;
    background-position:50%;
    background-size:cover
}
.card-authentication {
    flex-grow:1;
    width:100%;
    max-width:560px;
    margin:2rem 1rem
}
.card-authentication .logo {
    width:100%;
    max-width:100%;
    max-height:100px;
    margin:0 auto 2.5rem 0
}
.card-authentication .h1,
.card-authentication h1 {
    margin-bottom:2rem
}
.card-authentication>.card-body {
    padding:calc(1.625rem + 4.5vw) calc(1.475rem + 2.7vw)
}

@media(min-width:1200px) {
    .card-authentication>.card-body {
        padding:5rem 3.5rem
    }
}
.card-authentication>.card-footer {
    padding:calc(1.375rem + 1.5vw) calc(1.475rem + 2.7vw)
}
@media(min-width:1200px) {
    .card-authentication>.card-footer {
        padding:2.5rem 3.5rem
    }
}
.card-authentication>.card-footer p {
    margin-bottom:0
}
.card-authentication>.card-body+.card-footer {
    margin-top:-1rem
}
</style>
