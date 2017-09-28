<template>
    <input type="text" class="user-input" placeholder="Find User ..." v-model="string" @input="getListUser">
</template>

<script>

    export default {
        data: function () {
            return {
                string: null,
                initData: null,
            }
        },
        props: ['users'],
        mounted: function() {
            this.initData = this.users; // как ЭТО РАБОТАЕТ??? АААААА!!!
        },
        methods: {
            getListUser: function (evt) {

                console.log(this.initData);

                const needleUsers = this.users.filter((elem, index, arr) => {

                    if( elem.name.toLowerCase().includes(`${this.string.toLowerCase()}`) ||
                        elem.surname.toLowerCase().includes(`${this.string.toLowerCase()}`) ||
                        elem.patronymic.toLowerCase().includes(`${this.string.toLowerCase()}`)) {

                        return elem;

                    }
                });

                if(needleUsers.length !== 0) {
                    this.$emit('needleUsers', needleUsers);
                }

                if(!this.string) {
                    this.$emit('needleUsers', this.initData);
                }

            }
        }
    }

</script>

<style lang="scss">
    .user-input {
        width: 100%;
    }
</style>