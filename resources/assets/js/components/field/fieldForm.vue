<template>
    <div>
        <process :update="error" :message="messageError" :error="true"></process>
        <process :update="update" :message="messageProcess"></process>

        <validation v-show="errorsFlag" :errors="validateMessages" :value="{fieldName}"
                    v-on:validation="rulesValidation"></validation>

        <form action="#">

            <div class="form-group">
                <label for="field-name">Имя поля</label>
                <input class="form-control" type="text" id="field-name" name="fieldName" v-model="fieldName"
                       @input="setFlag">
            </div>

            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="display" v-model="display">
                    Отображать поле в таблицу
                </label>
            </div>

            <div class="form-group">
                <button class="btn  btn-primary" @click.prevent="addField">Добавить поле</button>
            </div>

        </form>
    </div>
</template>

<script>

    import process from '../dateProcess/process.vue';
    import validation from '../dateProcess/authProcess.vue';
    import GoValidator from '../../utils/validation.js';
    import {clearData, CONFIG_URLS} from '../../utils/other.js';

    export default {
        data: function () {

            return {
                fieldName: '',
                display: '',

                error: false,
                update: false,

                messageProcess: ['Данные в обработке'],
                messageError: [],

                errorsFlag: false,
                validate: false,
                validateMessages: {
                    fieldName: {
                        message: 'Не корекнтное имя поля',
                        regular: /^[a-zA-z]{8,16}$/,
                    },
                }

            }

        },
        methods: {

            rulesValidation: function (rules) {
                console.log(rules);
                this.validate = rules;
            },

            setFlag: function () {
              this.errorsFlag = true;
            },

            addField: function () {

                Promise.resolve()
                    .then(()=> {

                        if(!this.validate) {
                            throw new Error('Не коректно заполнено поля');
                        }

                    })
                    .then(() => {

                        const fieldData = {
                            name: this.fieldName,
                            display: this.display,
                        };

                        return axios.post(CONFIG_URLS.ADD_FIELD_URL, fieldData);
                    })
                    .catch((error) => {
                        this.update = false;
                        this.error = true;

                        const validation = new GoValidator(error);
                        this.messageError = validation.setError();

                        clearData(this.messageError, this, 'update', 'error'); // че бля. this. Вот это я намутил...
                    });
            }
        },
        components: {
            process,
            validation,
        }
    }
</script>

<style lang="scss">

</style>