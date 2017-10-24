// может замутить передачу ошибок через метод???
// и воспользоваться патерном синглтон для класса???

export default class GoValidator {

    constructor(error) {
        this.error = error;
    }

    setError() {

        const messagesArray = [];

        if ( this._checkResponse() && this._checkStatus() ) {

            for (let key in this.error.response.data) {

                for (let err = 0; err < this.error.response.data[key].length; err++) {
                    messagesArray.push(this.error.response.data[key][err]);
                }

            }
            // Тут можно убрать else. Если возвращать массив в if, но стоит ли жертвовать логикой ради пары строк???
        } else {
            messagesArray.push(this.error.message);
        }

        return messagesArray;

    }

    _checkResponse() {

        return this.error.hasOwnProperty('response');

    }

    _checkStatus() {

        const badValidation = 422; // если с валидаций не прошла
        return (+this.error.response.status) === 422;
    }

}