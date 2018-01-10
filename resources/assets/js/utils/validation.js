// может замутить передачу ошибок через метод???
// и воспользоваться патерном синглтон для класса???

export default class GoValidator {

    constructor(error) {
        this.error = error;
    }

    setError() {

        const messagesArray = [];

        if (this._checkResponse() && this._checkStatus()) {

            console.log(this.error);
            console.dir(this.error);

            if (+this.error.response.status === 422) {
                messagesArray.push(this.error.response.data[0]);
            } else {
                for (let key in this.error.response.data) {
                    for (let err = 0; err < this.error.response.data[key].length; err++) {
                        messagesArray.push(this.error.response.data[key][err]);
                    }
                }
            }


        } else {
            console.log(this.error.message);
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