<template>
    <input type="text" class="user-input" placeholder="Find User ..." v-model="string" @input="getListUser">
</template>

<script>

    export default {
        data: function () {
            return {
                string: null,
            }
        },
        props: ['data'],
        methods: {
            getListUser: function (evt) {

                // проблема из за реактивной даты. Так как у меня дата обновляется и здесь!!!

                const copyData = this.data.slice();
                console.log(this.string);

                if (this.string === '' || this.string === ' ') {
                    this.$emit('needleUsers', this.data);
                }

                const needleUsers = copyData.filter((elem, index, arr) => {
                    // попробовать переписать это тройное условие на функцию
                    // в которую передается массив и там что то делается
                    if( elem.name.toLowerCase().includes(`${this.string.toLowerCase()}`) ||
                        elem.surname.toLowerCase().includes(`${this.string.toLowerCase()}`) ||
                        elem.patronymic.toLowerCase().includes(`${this.string.toLowerCase()}`)) {

                        return elem;

                    }
                });

                this.$emit('needleUsers', needleUsers);

            }
        }
    }

</script>

<style lang="scss">
    .user-input {
        width: 100%;
    }
</style>