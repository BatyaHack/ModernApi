<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th v-for="field in fields">{{field}}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users" @click="setCurrentUser">
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
                firstDataFlag: false,
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