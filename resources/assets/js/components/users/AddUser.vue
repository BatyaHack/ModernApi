<template>
    <div>
        <div class="form-group">
            <button class="btn btn-info" @click="show = !show">Открыть</button>
        </div>

        <transition name="fade">

            <form action="/api/personal" method="post" v-if="show">

                <div class="form-group" v-for="field in fields" v-if="field != 'created_at' && field != 'updated_at' && field != 'id'">
                    <label :for="field">{{field}}</label>
                    <input type="text" class="form-control  jsNewUser" :id="field" placeholder="Заполните поле" :name="field">
                </div>


                <div class="form-group">
                    <button class="btn btn-success" @click.prevent="sendData">Добавить</button>
                </div>
            </form>

        </transition>
    </div>
</template>

<script>
    import {CONFIG_URLS} from '../../utils/other.js';

    export default {
        data: function () {
            return {
                show: false,
                user: {},
            }
        },
        props: ['fields'],
        methods: {
            sendData: function () {

                const self = this.user;

                const inputs = document.querySelectorAll('.jsNewUser');
                [...inputs].forEach((elem, index, arr) => {
                    self[elem.name] = elem.value;
                });

                axios.post(CONFIG_URLS.GET_PERSONAL_URL, this.user)
                    .then((data) => {

                        const dataAdapter = {};

                        dataAdapter.id = data.data.id;


                        for (let item in data.data) {
                            dataAdapter[item] = data.data[item];
                        }

                        return dataAdapter;

                    })
                    .then((data) => this.$emit('newUser', data))
                    .catch((err) => console.log(err));
            }
        }
    }
</script>

<style lang="scss">
    .user-block {
        display: flex;
        justify-content: space-between;
        width: 500px;
        margin: 20px 0;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }

    .fade-enter, .fade-leave-to {
        opacity: 0
    }
</style>
