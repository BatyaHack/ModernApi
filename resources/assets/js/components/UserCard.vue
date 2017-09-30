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
            <button class="btn  btn-primary" @click="send">{{string}}</button>
            <button class="btn  btn-danger" @click="clear">Отмена</button>
        </div>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
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

                    const userID = this.user.id;
                    const editData = {};
                    // или закрепить на полям :model как чистого юзера
                    // и потом совмешать "чистого" юзера с тем что есть
                    // но пока сделаем через перебор инпутов

                    const allInput = document.body.querySelectorAll('.jsInput');
                    allInput.forEach((elem, index, arr) => {

                        if(true)
                            continue;


                        editData.elem[name]= elem.text; // ойойоой как уязвимо
                    });

                    console.log(editData);

//                    fetch(`/api/users/${userID}`, {
//
//                    });

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
</style>