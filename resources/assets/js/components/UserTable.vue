<template>
    <div class="container-fluid">

        <user-find :users="users" @needleUsers="needleUsers" v-if="showFind"></user-find>

        <div class="col-md-2">
            <user-card :user="currentUser" :admin="admin" @correctUser="updateUser"
                       @deleteUser="deleteUser"></user-card>
            <user-form :fields="fields" @newUser="renderNewUser" v-if="admin"></user-form>
        </div>

        <div class="col-md-10">
            <table class="users-table">
                <thead class="users-table__head">
                <tr>
                    <th v-for="field in fields">{{field}}</th>
                </tr>
                </thead>
                <tbody class="users-table__body">
                <tr v-for="user in users" @click="setCurrentUser">
                    <td v-for="data in user">{{data}}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
    import UserForm from './AddUser.vue';
    import UserCard from './UserCard.vue';
    import UserFind from './UserFind.vue';

    export default {
        data: function () {
            return {
                users: null,
                fields: null,
                currentUser: null,
                showFind: false,
                admin: false,
            }
        },
        beforeCreate() {
            fetch('/api/users')
                .then((data) => data.json())
                .then((data) => {
                    this.fields = data.columns;
                    this.users = data[0];
                    this.admin = data.admin;
                    this.showFind = true;
                    this.currentUser = this.users[0];
                })
        },
        components: {
            UserForm,
            UserCard,
            UserFind
        },
        methods: {
            renderNewUser: function (newUser) {
                this.users.push(newUser);
            },
            setCurrentUser: function (evt) {
                const curretID = evt.target.parentElement.children[0].innerText;

                this.currentUser = this.users.find((elem, index, arr) => {
                    if (elem.id == curretID) {
                        return elem;
                    }
                });
            },
            needleUsers: function (needleUsers) {
                this.currentUser = needleUsers[0];
                this.users = needleUsers;
            },
            updateUser: function (user) {

                const updateUser = this.users.find((elem, index, arr) => {
                    return elem.id === user.id;
                });

                Object.assign(updateUser, user);

            },
            deleteUser: function (id) {

                let indexUser = null;

                this.users.find((elem, index, arr) => {
                    if (elem.id === id) {
                        indexUser = index;
                        return true;
                    }
                });

                this.users.splice(indexUser, indexUser+1);

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
