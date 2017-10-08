<template>
    <input type="text" class="user-input" placeholder="Find User ..." v-model="string" @input="getListUser">
</template>

<script>

    export default {
        data: function () {
            return {
                string: null,
                initData: null,
                oldLength: null,
            }
        },
        props: ['users'],
        mounted: function () {
            this.initData = this.users;
        },
        methods: {
            getData: function () {
                Object.assign(this.users, this.initData);
            },
            getListUser: function (evt) {

                const throttling = setTimeout(() => {

                    clearTimeout(throttling);

                    if (this.oldLength > this.string.length) {
                        this.getData();
                    }


                    const needleUsers = this.users.filter((elem, index, arr) => {

                        if (elem.name.toLowerCase().includes(`${this.string.toLowerCase()}`) ||
                            elem.family.toLowerCase().includes(`${this.string.toLowerCase()}`)) {

                            return elem;

                        }
                    });

                    this.$emit('needleUsers', needleUsers);

                    this.oldLength = this.string.length;
                }, 300);
            }
        }
    }


</script>

<style lang="scss">
    .user-input {
        width: 100%;
    }
</style>