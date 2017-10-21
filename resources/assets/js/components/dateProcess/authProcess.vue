<template>
    <div class="validation-wrapper">
        <p class="error" v-for="(error, key) in validation" v-if="!error">
            {{errors[key].message}}
        </p>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                validRules: {},
            }
        },
        props: ['errors', 'value'],
        computed: {
            validation: function () {
                this.$emit('validation', this.isValid());
                return this.toCount();
            },
        },
        methods: {
            isValid: function () {
                return Object.keys(this.validRules).every((key)=> {
                   return this.validRules[key];
                });
            },
            toCount: function () {
                let rulesObject = {};

                for (let key in this.value) {
                    rulesObject[key] = this.errors[key].regular.test(this.value[key].trim());
                }

                this.validRules = rulesObject;
                return rulesObject;
            }
        }
    }
</script>

<style lang="scss">

</style>