<template>
    <div class="container">
        <div class="col-md-12">
            <form action="#" method="get">
                <process :update = "error" :message = "errorMessage" :error="true"></process>
                <process :update = "update" :message = "message"></process>
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

    import process from '../dateProcess/process.vue';

    export default {
        data: function () {
            return {
                email: null,
                password: null,
                error: false,
                update: false,
                message: 'Данные в обработке',
                errorMessage: 'С данными что то не так'
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
                        localStorage.setItem('modernToken', token.token);
                        this.update = false;
                        window.location.pathname = '/';
                    })
                    .catch((err) => {
                        this.update = false;
                        this.error = true;
                        this.errorMessage = err.message;

                        setTimeout(() => {
                            this.error = false;
                        }, 3000);
                    });

            }

        },
        components: {
            process,
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