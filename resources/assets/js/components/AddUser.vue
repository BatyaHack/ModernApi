<template>
    <form action="/api/users" method="post">

        <label>
            <span></span>
            <input type="text">
        </label>

        <ul :inputs="fields">
            <li v-for="input in inputs">{{input}}</li>
        </ul>

        <button>Добавить</button>

    </form>
</template>

<script>
    export default {
        props: ['inputs'],
    }
</script>

<style>

</style>