<template>
    <div class="container-fluid">

        <user-find :users="users" @needleUsers="needleUsers" v-if="showFind"></user-find>

        <div class="col-md-2">
            <user-card :user="currentUser" :admin="admin" @correctUser="updateUser"
                       @deleteUser="deleteUser"></user-card>
            <user-form :fields="fields" @newUser="renderNewUser" v-if="admin"></user-form>
            <user-link :login="admin"></user-link>
        </div>

        <div class="col-md-10">
            <UserTable :users="users" :fields="fields" @currentUser="setCurrentUser"></UserTable>
        </div>

    </div>
</template>

<script>
    import UserForm from './AddUser.vue';
    import UserCard from './UserCard.vue';
    import UserFind from './UserFind.vue';
    import UserLink from '../auth/link.vue';
    import UserTable from '../users/table.vue';
    import {CONFIG_URLS} from '../../utils/other.js';



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

            const token = localStorage.getItem('modernToken');

            console.log(token);

            axios({
                method: 'GET',
                url: CONFIG_URLS.GET_PERSONAL_URL,
                headers: {
                    'x-custom-token' : token,
                }
            })
                .then((data) => {
                    return data.data;
                })
                .then((data) => {
                    console.log(data);
                    this.fields = data.columns;
                    this.users = data[0];

                    if(data.user !== false) {
                        this.admin = data.user.original.result.id;
                    } else {
                        this.admin = data.user;
                    }

                    this.showFind = true;
                })
        },
        components: {
            UserForm,
            UserCard,
            UserFind,
            UserLink,
            UserTable,
        },
        methods: {
            renderNewUser: function (newUser) {
                this.users.push(newUser);
            },
            setCurrentUser: function (data) {
                this.currentUser = data;
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

                this.users.splice(indexUser, 1);
            }
        }
    }
</script>


<style lang="scss">

</style>
