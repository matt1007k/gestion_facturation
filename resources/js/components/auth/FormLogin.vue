<template>
    <form @submit.prevent="handleLogin()">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                <i class="icon-user"></i>
                </span>
            </div>
            <input class="form-control" type="text" placeholder="Username">
        </div>
        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text">
                <i class="icon-lock"></i>
                </span>
            </div>
            <input class="form-control" type="password" placeholder="Password">
        </div>
        <div class="row">
            <div class="col-6">
                <button class="btn btn-primary px-4" type="button">Ingresar</button>
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-link px-0" type="button">Olvide mi contraseña?</button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            user: {},
            errors: []
        }
    },
    methods: {
        handleLogin() {
            console.log('login');
            
        }
    },
}
</script>

<style>

</style>
