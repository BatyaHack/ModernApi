<template>
    <div>
        <div class="form-group">
            <button class="btn btn-info" @click="show = !show">Открыть</button>
        </div>

        <transition name="fade">

            <form action="/api/personal" method="post" v-if="show">

                <label class="user-block" v-for="field in fields">
                    <div class="user-wrapper" v-if="field != 'created_at' && field != 'updated_at' && field != 'id'">
                        <span class="user-block__label">{{field}}</span>
                        <input class="user-block__input" type="text" :name="field">
                    </div>
                </label>

                <div class="form-group">
                    <button class="btn btn-success" @click.prevent="sendData">Добавить</button>
                </div>
            </form>

        </transition>
    </div>
</template>

<script>
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

                const inputs = document.querySelectorAll('.user-block__input');
                [...inputs].forEach((elem, index, arr) => {
                    self[elem.name] = elem.value;
                });


                axios.post('/api/personal', this.user)
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
