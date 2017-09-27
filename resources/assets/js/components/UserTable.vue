<template>
    <div class="container-fluid">

        <div class="col-md-2">
            <user-form :fields = "fields" @newUser="renderNewUser"></user-form>
        </div>

        <div class="col-md-10">
            <table class = "users-table">
                <thead class = "users-table__head">
                <tr>
                    <th v-for="field in fields">{{field}}</th>
                </tr>
                </thead>
                <tbody class = "users-table__body">
                <tr v-for="user in users">
                    <td v-for="data in user">{{data}}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
    import UserForm from './AddUser.vue';

    export default {
        data: function () {
            return {
                users: null,
                fields: null
            }
        },
        created() {
            fetch('/api/users')
                .then( (data) => data.json() )
                .then( (data) => {
                    this.fields = data.columns;
                    this.users = data[0];
                })
        },
        components: {
            UserForm
        },
        methods: {
            renderNewUser: function (newUser) {
                this.users.push(newUser);
            }
        }
    }
</script>


<style lang="scss">
    .users-table {
        width: 100%;
        border-spacing: 0;

        &__head {

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
                    background-color: rgba(0, 0, 0, 0.3);
                }
            }
            tr:nth-child(odd) {
                background-color: rgba(0, 0, 0, 0.5);
                &:hover {
                    background-color: rgba(0, 0, 0, 0.3);
                }
            }
        }
    }
</style>
