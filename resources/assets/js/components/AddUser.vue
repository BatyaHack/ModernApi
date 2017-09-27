<template>
    <div>
        <button @click="show = !show">Открыть</button>

        <transition name="fade">

            <form action="/api/users" method="post" v-if="show">

                <label class="user-block" v-for="field in fields">
                    <span class="user-block__label">{{field}}</span>
                    <input class="user-block__input" type="text" :name="field">
                </label>

                <button @click.prevent="sendData">Добавить</button>
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

                fetch('/api/users', {
                    method: 'POST',
                    body: JSON.stringify(this.user),
                    headers: {
                        'Access-Control-Allow-Origin': `*`,
                        'Content-Type': `application/json`,
                    }
                })
                    .then((data) => console.log('Дата отправлена'))
                    .then(this.$emit('newUser', this.user))
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
