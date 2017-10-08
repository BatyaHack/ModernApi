<template>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <register></register>
            </div>
        </div>
    </div>
</template>

<script>
    import register from '../components/auth/register.vue';

    export default {
        components: {
            register,
        }
    }
</script>

<style lang="scss">

</style>