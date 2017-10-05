<template>
    <div>
        <login></login>
        <auth></auth>
        <client></client>
        <personal></personal>
    </div>
</template>

<script>
    import auth from '../components/passport/AuthorizedClients.vue';
    import client from '../components/passport/Clients.vue';
    import personal from '../components/passport/PersonalAccessTokens.vue';
    import login from '../components/auth/login.vue'

    export default {
        components: {
            login,
            auth,
            client,
            personal,
        }
    }
</script>

<style lang="scss">

</style>