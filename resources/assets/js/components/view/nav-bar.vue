<template>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">modern expo</a>
            </div>

            <div class="collapse navbar-collapse navbar-left" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav">
                    <li><a href="/field" v-show="checkLogin">Добавить поле</a></li>
                    <li><a href="/add-user" v-show="checkLogin">Добавить пользователя</a></li>
                </ul>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">

                <ul class="nav navbar-nav  navbar-right" v-show="!checkLogin">

                    <li><a href="/register">Регистрация</a></li>
                    <li><a href="/login">Вход</a></li>

                </ul>

                <ul class="nav navbar-nav  navbar-right" v-show="checkLogin">

                    <li><a href="#">Привет, {{adminName}}</a></li>
                    <li><a href="#">Выход</a></li>

                </ul>

            </div>
        </div>
    </nav>

</template>

<script>
    export default {

        data: function () {
            return {
                checkLogin: null,
                adminName: '',
            }
        },
        mounted: function () {
            this.$root.$on('someEvent', (isAdmin, data = '') => {
                this.checkLogin = isAdmin;
                this.adminName = data.name;
            })
        }
    }
</script>

<style lang="scss">

</style>