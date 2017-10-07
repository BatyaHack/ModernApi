<template>
    <div class="user-class">
        <img src="" alt="Фото пользователя">
        <template v-if="status === formStatus.EDIT">
            <div class="user-class__info" v-for="(info, key) in user">
                <span class="user-class__key">{{key}}</span>
                <span class="user-class__info">{{info}}</span>
            </div>
        </template>
        <template v-if="status === formStatus.SEND">
            <div class="user__create" v-for="(info, key) in user">
                <span class="user-class__key">{{key}}</span>
                <input class="input  jsInput" type="text" :name="key" :placeholder="info">
            </div>
        </template>
        <div class="form-group" v-if="user && admin">
            <p class="status__text  status__text--success" v-show="update"><span
                    class="glyphicon glyphicon-repeat"></span> Идет обновление данных</p>
            <p class="status__text  status__text--error  bg-danger" v-show="error"><span
                    class="glyphicon glyphicon-remove"></span> Что что то пошло не так</p>
            <div class="btn-group">
                <button class="btn  btn-primary" @click="send">{{string}}</button>
                <button class="btn  btn-success" @click="clear">Отмена</button>
                <button class="btn  btn-danger" @click="deleteUser">Удалить</button>
            </div>
        </div>
    </div>
</template>

<script>
    // не становится ли тут компонет завизимым от файла утлиты???

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

                    axios.put(`/api/personal/${userID}`, editData)
                        .then((data) => {
                            return data.data;
                        })
                        .then((data) => {
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
                axios.delete(`/api/personal/${this.user.id}`)
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
    }

    .user__create {
        display: flex;
        justify-content: space-between;
        align-items: center;
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