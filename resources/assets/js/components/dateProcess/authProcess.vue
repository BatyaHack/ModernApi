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
        watch: {
            errors: function () {
                this.validation;
            },
            value: function () {
                console.log('Логин: ', this.value.email);
                console.log('Пароль: ', this.value.password);
                this.validation;
            },
        },
        computed: {
            validation: function () {
                // это просто лучший костыль в моей жизни. Мне спева нужно было обработать наличие ошибок
                // а потом уже эвент о том что данные поменялись
                setTimeout(() => {
                    this.$emit('validation', this.isValid());
                }, 100);

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