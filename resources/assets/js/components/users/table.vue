<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th v-for="field in fields">{{field}}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in getUsers" @click="setCurrentUser">
            <td v-for="data in user">{{data}}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {

        data() {
            return {
                dataUser: null,
            }
        },
        props: ['users', 'fields'],
        methods: {
            setCurrentUser: function (evt) {

                const allTr = document.querySelectorAll('tr');

                [...allTr].forEach((elem, index, arr) => {
                    elem.classList.remove('current-user');
                });

                evt.target.parentElement.classList.add('current-user');

                const currentID = evt.target.parentElement.children[0].innerText;

                const currentUser = this.users.find((elem, index, arr) => {
                    return elem.id === +currentID;
                });

                this.$emit('currentUser', currentUser);
            }
        },
        computed: {
            // ЭТО ТАКАЯ ПАРАША ШО Я ...
            getUsers: function () {

                if (this.users === null) {
                    return [];
                }

                let all_key = [];

                let fullUsers = this.users.map((elem, index, arr) => {

                    let self = elem;

                    elem.data.forEach((elem, index, arr) => {
                        all_key.push(elem.field.name); // заполняю массив всеми кеями что есть
                    });

                    return self;

                });

                all_key.forEach((elem, index, arr) => {

                    let key = elem;

                    fullUsers.forEach((elem, index, arr) => {

                        elem[key] = ' ';

                    });

                });

                fullUsers.forEach((elem, index, arr) => {

                    let self = elem;

                    elem.data.forEach((elem, index, arr) => {

                        self[elem.field.name] = elem.data;

                    });

                    delete self.data;

                });

                return fullUsers;

            }
        }
    }
</script>

<style lang="scss">
    .table {
        tbody {

            tr {
                cursor: pointer;

                &:hover {
                    color: #ffffff;
                    background: rgba(0, 0, 0, 0.3);
                }
            }

            .current-user {
                color: #ffffff !important;
                background: rgba(0, 0, 0, 0.3) !important;
            }
        }
    }
</style>