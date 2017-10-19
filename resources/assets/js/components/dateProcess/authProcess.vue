<template>
    <div class="validation-wrapper">
        <p class="error" v-for="(error, key) in rules" v-if="!error">
            {{errors[key].message}}
        </p>
    </div>
</template>

<script>
    export default {
        props: ['errors'],
        computed: {
            validation: function () {
                return {
                    email: this.errors.email === null || /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.errors.email.value),
                    name: this.errors.name === null || /\w{8,16}/gi.test(this.errors.name.value),
                    password: this.errors.password === null || /\w{8,16}/gi.test(this.errors.password.value),
                }
            },
            rules: function () {

                clearTimeout(pause);

                let pause = setTimeout(() => {

                    this.$emit('validation', this.isValid());

                }, 300);


                return this.validation;
            },
        },
        methods: {
            isValid: function () {
                return Object.keys(this.validation).every((key)=> {
                   return this.validation.key;
                });
            }
        }
    }
</script>

<style lang="scss">

</style>