<template>
    <form action="/api/auth/register" method="post">

        <!--Чето мне не нравится этот блок-->

        <process :update="update" :message="messageProcess"></process>
        <process :update="success" :message="messageSuccess"></process>
        <process :update="error" :error="error" :message="messageError"></process>

        <!---->

        <validation :errors="validateMessages" v-on:validation="rulesValidation"></validation>


        <div class="form-group">
            <label for="name">Имя</label>
            <input class="form-control" type="text" name="name"
                   id="name" v-model="name">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" type="email" name="email"
                   id="email" v-model="email">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input class="form-control" type="password" name="password" id="password" v-model="password">
        </div>
        <div class="form-group">
            <label for="rep_password">Повтрите пароль</label>
            <input class="form-control" type="password" name="rep_password"
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
                name: null,
                email: null,
                password: null,
                repPassword: null,

                update: false,
                error: false,
                success: false,

                messageProcess: 'Регистрация',
                messageError: 'Данные указаны невероно',
                messageSuccess: 'Вы успешно зареганы',

                validate: false,
                validateMessages: {
                    email: {
                        value: '' || '',
                        message: 'Не корекнтное email',
                    },
                    name: {
                        value: '' || '',
                        message: 'Не корекнтное имя'
                    },
                    password: {
                        value: '' || '',
                        message: 'Не коректный пароль'
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
                            console.log(this.email);
                            console.log(this.repPassword);
                            throw new Error('Упс ваши пароли не верны!!!');
                        }

                        if(!this.validate) {
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
                        this.messageError = error.message;
                        this.error = true;

                        setTimeout(() => {

                            this.error = false;
                            this.update = false;

                        }, 3000);
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

</style>