<template>
    <div>
        <nav-bar></nav-bar>
        <user-table></user-table>
    </div>
</template>


<script>
    import UserTable from '../components/users/UserTable.vue';
    import NavBar from '../components/view/nav-bar.vue';

    export default {
        components: {
            UserTable,
            NavBar,
        }
    }
</script>


<style lang="scss">

</style>