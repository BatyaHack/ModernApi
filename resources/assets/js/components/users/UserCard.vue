<template>
    <div class="user-class">
        <template v-if="status === formStatus.EDIT">
            <div class="user-class__info" v-for="(info, key) in user">
                <span class="user-class__key">{{key}}</span>
                <span class="user-class__value">{{info}}</span>
            </div>
        </template>
        <template v-if="status === formStatus.SEND">
            <div class="user-class__info" v-for="(info, key) in user">
                <span class="user-class__key">{{key}}</span>
                <input class="input  jsInput  user-class__value" type="text" :name="key" :placeholder="info">
            </div>
        </template>
        <div class="form-group  helper-wrapper  text-center" v-if="user && admin">
            <p class="status__text  status__text--success" v-show="update"><span
                    class="glyphicon glyphicon-repeat"></span> Идет обновление данных</p>
            <p class="status__text  status__text--error  bg-danger" v-show="error"><span
                    class="glyphicon glyphicon-remove"></span> Что что то пошло не так</p>
            <div class="btn-group">
                <button class="btn  btn-primary" @click="send">{{string}}</button>
                <button v-if="status === formStatus.SEND" class="btn  btn-success" @click="clear">Отмена</button>
                <button class="btn  btn-danger" @click="deleteUser">Удалить</button>
            </div>
        </div>
    </div>
</template>

<script>
    // не становится ли тут компонет завизимым от файла утлиты???
    import {CONFIG_URLS} from '../../utils/other.js';

    export default {
        data: function () {
            return {
                update: false,
                error: false,
                string: null,
                status: null,
                formStatus: {
                    EDIT: 1,
                    SEND: 2,
                },
            }
        },
        mounted() {
            this.setStatus(this.formStatus.EDIT);
        },
        props: {
            user: null,
            admin: false,
        },
        methods: {
            send: function () {

                if (this.status === this.formStatus.SEND) {

                    this.update = true;
                    const userID = this.user.id;
                    const editData = {};
                    // или закрепить на полям :model как чистого юзера
                    // и потом совмешать "чистого" юзера с тем что есть
                    // но пока сделаем через перебор инпутов

                    const allInput = document.body.querySelectorAll('.jsInput');
                    allInput.forEach((elem, index, arr) => { //forEach метод, а не цикл

                        if (!elem.value) {
                            console.log('Пропускаю');
                            return;
                        }
                        console.log(elem.name);
                        editData[elem.name] = elem.value; // ойойоой как уязвимо
                    });


                    axios.put(`${CONFIG_URLS.GET_PERSONAL_URL}/${userID}`, editData)
                        .then((data) => {
                            return data.data;
                        })
                        .then((data) => {
                                console.log(data);
                                this.$emit('correctUser', data);
                                this.update = false;
                            }
                        )
                        .catch((err) => {
                            this.error = true;

                            setTimeout(() => {
                                this.update = false;
                                this.error = false;
                            }, 3000);

                        });
                } else {
                    this.setStatus(this.formStatus.SEND);
                }
            },
            clear: function () {
                this.setStatus(this.formStatus.EDIT);
            },
            setStatus: function (value) {
                this.status = value;
                switch (value) {
                    case this.formStatus.EDIT:
                        this.string = 'Править';
                        break;
                    case this.formStatus.SEND:
                        this.string = 'Отправить';
                        break;
                }
            },
            deleteUser: function () {
                this.update = true;
                axios.delete(`${CONFIG_URLS.GET_PERSONAL_URL}/${this.user.id}`)
                    .then(() => {
                        this.update = false;
                        this.$emit('deleteUser', this.user.id);
                    })
                    .catch(() => {
                        this.error = true;
                        // Перенести в функцию;
                        setTimeout(() => {
                            this.update = false;
                            this.error = false;
                        }, 3000);
                    })
            }
        }
    }

</script>

<style lang="scss">
    .user-class__info {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin: 3px 0;
        padding: 5px 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.4);
    }

    .user__create {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .helper-wrapper {
        margin-top: 15px;
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