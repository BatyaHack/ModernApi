<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-2 nav__panel">
                <div class="row">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#" data-link="users">Пользователи</a></li>
                        <li><a href="#" data-link="admins">Админы</a></li>
                        <li><a href="#">Столбцы</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10">
                <UserTable :users="users.users" :fields="users.fields" v-if="userTable"></UserTable>
                <UserTable :users="admins.admins" v-if="adminTable"></UserTable>
            </div>

        </div>
    </div>
</template>

<script>
    import UserTable from '../components/users/table.vue'
    export default {
        data: function () {
            return {
                userTable: false,
                adminTable: true,
                users: {
                    users: null,
                    fields: null,
                },
                admins: {
                    admins: null,
                    fields: null,
                }
            }
        },
        components: {
            UserTable,
        },
        beforeCreate() {

            function getPersonals() {
                return axios.get('/api/personal');
            }

            function getAdmins() {
                return axios.get('/api/admins');
            }

            axios.all([getPersonals(), getAdmins()])
                .then(axios.spread((personals, admins) => {
                    this.users.users = personals.data[0];
                    this.users.fiels = personals.data.columns;

                    this.admins.admins = admins.data;

                    console.log(this.admins.admins);
                    console.log(this.users.users);

                }))
                .catch((err)=> {
                    console.log(err);
                });
        },
    }
</script>

<style lang="scss">
    .nav {
        &__panel {
            background: rgba(22, 38, 23, 0.33);
        }
    }
</style>