<template>
    <div class="form-group">
        <div class="btn-group">
            <a href="/login" class="btn btn-success" v-if="!login">Залогинеться</a>
            <!--Позже только для админа-->
            <a href="/register" class="btn btn-primary" v-if="!login">Зарегестрироваться</a>
            <a href="/logout" class="btn btn-danger" v-if="login" @click.prevent="logout">Разлогинеться</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            login: false,
        },
        methods: {
            logout: function () {
                localStorage.removeItem('modernToken');
                location.reload();
            }
        }
    }
</script>

<style lang="scss">

</style>