/**
 * Created by GoldGym on 14.10.2017.
 */
class validation {

    constructor(email = true, name = true , password = true) {
        this.email = email;
        this.name = name;
        this.password = password;

        this._emailReg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        this._nameReg = /[a-z]{6,}/gi;
        // this._passwordReg = //;
    }

    __validFacade () {
        return {
            email: this._emailReg.test(this.email),
            name: this.name,
            password: this.password,
        }
    }

    validation() {
        console.log(this.nameReg);
        return Object.keys(this.__validFacade()).every((key) => {
           return this.__validFacade()[key];
        });
    }
}

export default validation;