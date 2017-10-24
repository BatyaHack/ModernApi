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
            <input class="form-control" type="password" name="password" @input="setFlag" id="password"
                   v-model="password">
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
    import goLogin from '../../utils/login.js';
    import GoValidator from '../../utils/validation.js';
    import {clearData, CONFIG_URLS} from '../../utils/other.js';

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

                messageProcess: ['Регистрация'],
                messageError: [],
                messageSuccess: ['Вы успешно зареганы'],

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
                            throw new Error('Заполните форму');
                        }

                    })
                    .then(() => {
                        return axios.post(CONFIG_URLS.REGISTER_URL, data)
                    })
                    .then(() => {
                        return axios.post(CONFIG_URLS.LOGIN_URL, data);
                    })
                    .then((data) => {
                        goLogin(data);
                    })
                    .catch((error) => {
                        this.update = false;
                        this.error = true;

                        const validation = new GoValidator(error);
                        this.messageError = validation.setError();

                        clearData(this.messageError, this, 'update', 'error'); // че бля. this. Вот это я намутил...
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