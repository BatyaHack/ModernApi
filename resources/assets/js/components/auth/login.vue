<template>
    <div class="container">
        <div class="col-md-12">
            <form action="#" method="get">
                <div class="form-group" v-show="error">
                    <p class="text-error"> Вы ввели неверный логин или пароль </p>
                </div>
                <div class="form-group" v-show="update">
                    <p class="status__text  status__text--success"><span
                            class="glyphicon glyphicon-repeat"></span> Идет обновление данных</p>
                </div>
                <div class="form-group">
                    <label for="email">Мыло</label>
                    <input type="email" class="form-control" id="email" placeholder="Мыло" v-model="email">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" id="password" placeholder="Пароль" v-model="password">
                </div>
                <div class="form-group">
                    <button class="btn  btn-success" @click="login">Залогинеться</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                email: null,
                password: null,
                error: false,
                update: false,
            }
        },
        methods: {

            login: function () {

                this.update = true;

                const loginData = {
                    email: this.email,
                    password: this.password
                };


                axios.post('/api/auth/login', loginData)
                    .then((data) => {

                        const token = data.data;
                        localStorage.setItem('modernToken', token);

                    })
                    .then(() => this.update = false)
                    .catch((err) => {
                        this.update = false;
                        this.error = true;

                        setTimeout(() => {
                            this.error = false;
                        }, 3000);
                    });

            }

        }
    }
</script>

<style lang="scss">

    .text-error {
        color: red;
    }

    .status__text {

        &--success {
            span {
                animation-name: update;
                animation-iteration-count: infinite;
                animation-duration: 1s;
                animation-timing-function: linear;
            }
        }

        &--error {

        }
    }

    @keyframes update {
        0% {
            transform: rotate(0deg)
        }
        100% {
            transform: rotate(360deg)
        }
    }

</style>