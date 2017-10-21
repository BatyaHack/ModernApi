<template>
    <form action="/api/auth/register" method="post">

        <!--Чето мне не нравится этот блок-->

        <process :update="update" :message="messageProcess"></process>
        <process :update="success" :message="messageSuccess"></process>
        <process :update="error" :error="error" :message="messageError"></process>

        <!---->


        <validation v-show="errorsFlag" :errors="validateMessages" :value="{name, email, password}"
                    v-on:validation="rulesValidation"></validation>


        <div class="form-group">
            <label for="name">Имя</label>
            <input class="form-control" type="text" name="name" @input="setFlag"
                   id="name" v-model="name">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" type="email" name="email" @input="setFlag"
                   id="email" v-model="email">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input class="form-control" type="password" name="password" @input="setFlag" id="password" v-model="password">
        </div>
        <div class="form-group">
            <label for="rep_password">Повтрите пароль</label>
            <input class="form-control" type="password" name="rep_password" @input="setFlag"
                   id="rep_password" v-model="repPassword">
        </div>
        <div class="form-group">
            <button class="btn btn-primary" @click.prevent="toRegister($event)">Зарегестрироваться</button>
        </div>
    </form>
</template>

<script>
    import process from '../dateProcess/process.vue';
    import validation from '../dateProcess/authProcess.vue';

    export default {
        data: function () {
            return {
                name: '',
                email: '',
                password: '',
                repPassword: '',

                update: false,
                error: false,
                success: false,

                messageProcess: 'Регистрация',
                messageError: [],
                messageSuccess: 'Вы успешно зареганы',

                errorsFlag: false,
                validate: false,
                validateMessages: {
                    email: {
                        message: 'Не корекнтное email',
                        regular: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    },
                    name: {
                        message: 'Не корекнтное имя',
                        regular: /\w{8,16}/,
                    },
                    password: {
                        message: 'Пример корректного пароля. Qwerty1991!',
                        regular: /(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]/,
                    }
                }
            }
        },
        methods: {
            rulesValidation: function (rules) {
                this.validate = rules;
            },

            toRegister: function (evt) {

                this.update = true;
                const data = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                };

                Promise.resolve()
                    .then(() => {

                        if (this.password !== this.repPassword) {
                            throw new Error('Упс ваши пароли не верны!!!');
                        }

                        if (!this.validate) {
                            throw new Error('Вы не исправили все ошибки!!!');
                        }
                    })
                    .then(() => {
                        return axios.post('/api/auth/register', data)
                    })
                    .then(() => {
                        // можно проверить правильность данных, которые пришли от сервера
                        // а только потом отправоять лошин
                        return axios.post('/api/auth/login', data);
                    })
                    // вот это можно было бы как то пложить в функцию. Так как слишком уж часто ее юзаю
                    .then((data) => {
                        const token = data.data;
                        localStorage.setItem('modernToken', token.token);
                        this.update = false;
                        window.location.pathname = '/';
                    })
                    .catch((error) => {
                        this.update = false;
                        this.error = true;

                        // что бы получить статус error.response.status

                        if (error.response.status == 422) {

                            for (let key in error.response.data) {

                                for(let err = 0; err < error.response.data[key].length; err++) {
                                    this.messageError.push(error.response.data[key][err]);
                                }
                            }

                        } else {
                            this.messageError = error.message;
                        }


                        setTimeout(() => {

                            this.error = false;
                            this.update = false;
                            this.messageError = [];

                        }, 7000);
                    });


            },

            setFlag: function () {
                this.errorsFlag = true;
            }
        },
        components: {
            process,
            validation,
        }
    }

</script>

<style lang="scss">

</style>