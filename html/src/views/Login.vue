<template>
    <div class="home">
        <LoginForm/>
    </div>
</template>

<script>
    // @ is an alias to /src
    import LoginForm from '@/components/LoginForm.vue'

    export default {
        name: 'login',
        components: {
            LoginForm
        }
    }
</script>
