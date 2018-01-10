<template>
    <div class="container">
        <div class="col-md-12">
            <form action="#" method="get">

                <process :update="error" :message="messageError" :error="true"></process>
                <process :update="update" :message="messageProcess"></process>

                <validation v-show="errorsFlag" :errors="validateMessages" :value="{email, password}"
                            v-on:validation="rulesValidation"></validation>

                <div class="form-group">
                    <label for="email">Мыло</label>
                    <input type="email" class="form-control" id="email" placeholder="Мыло" name="email"
                           v-model="email" @input="setFlag">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" id="password" placeholder="Пароль" name="password"
                           v-model="password" @input="setFlag">
                </div>
                <div class="form-group">
                    <button class="btn  btn-success" @click.prevent="login">Залогинеться</button>
                </div>
            </form>
        </div>
    </div>
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
                email: '',
                password: '',

                error: false,
                update: false,

                messageProcess: ['Данные в обработке'],
                messageError: [],

                errorsFlag: false,
                validate: false,
                validateMessages: {
                    email: {
                        message: 'Не корекнтное email',
                        regular: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    },
                    password: {
                        message: 'Такого пароля не может быть',
                        regular: /(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]/,
                    }
                }
            }
        },
        methods: {

            rulesValidation: function (rules) {
                console.log('rules: ' + rules);
                this.validate = rules;
            },

            setFlag: function () {
                this.errorsFlag = true;
            },

            login: function () {

                this.update = true;

                const loginData = {
                    email: this.email,
                    password: this.password
                };


                Promise.resolve()
                    .then (() => {

                        if(!this.validate) {
                            throw new Error ('Заполните форму');
                        }

                    })
                    .then(()=> {
                        return axios.post(CONFIG_URLS.LOGIN_URL, loginData);
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

            }

        },
        components: {
            process,
            validation,
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