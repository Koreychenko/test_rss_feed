<template>
    <div class="home">
        <RegisterForm/>
    </div>
</template>

<script>
    // @ is an alias to /src
    import RegisterForm from '@/components/RegisterForm.vue'

    export default {
        name: 'register',
        components: {
            RegisterForm
        }
    }
</script>
