<template>
    <div class="form-group" :class="{error : error}" v-show="update">
        <p class="status__text  status__text--success">

            <span v-show="update && !error" class="glyphicon glyphicon-repeat"></span>

            <span v-show="error" class="glyphicon glyphicon-remove"></span>

            {{getMessage}}

        </p>
    </div>
</template>

<script>
    export default {

        props: {
            update: null,
            message: null,
            error: false,
        },
        computed: {
            getMessage: function () {

                if(Array.isArray(this.message)) {
                    return this.message.join(': \n');
                }

                return this.message;

            }
        }

    }
</script>

<style lang="scss">
    .error {
        color: red;
    }
</style>