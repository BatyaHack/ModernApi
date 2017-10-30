<template>
    <table class="users-table">
        <thead class="users-table__head">
        <tr>
            <th v-for="field in fields">{{field}}</th>
        </tr>
        </thead>
        <tbody class="users-table__body">
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
                const currentID = evt.target.parentElement.children[0].innerText;

                const currentUser = this.users.find((elem, index, arr) => {
                    return elem.id === +currentID;
                });

                this.$emit('currentUser', currentUser);
            }
        },
        computed: {
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
    .users-table {
        width: 100%;
        border-spacing: 0;

        &__head {
            th {
                text-align: center;
            }
        }

        &__body {
            border-left: none;
            border-right: none;
            td {
                padding: 20px 0;
                text-align: center;
            }
            tr {
                cursor: pointer;
                transition: all 0.3s;
                &:hover {
                    background-color: rgba(0, 0, 0, 0.1);
                }
            }
            tr:nth-child(odd) {
                background-color: rgba(0, 0, 0, 0.2);
                &:hover {
                    background-color: rgba(0, 0, 0, 0.1);
                }
            }
        }
    }
</style>