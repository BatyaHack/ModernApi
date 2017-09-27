<template>
    <div class="user-class">
        <img src="" alt="Фото пользователя">
        <div class="user-class__info" v-for="(info, key) in user">
            <span class="user-class__key">{{key}}</span>
            <span class="user-class__info">{{info}}</span>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            user: null
        },
    }

</script>

<style lang="scss">
    .user-class__info {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin: 3px 0;
    }
</style>