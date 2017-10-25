export function clearData(clearDataArray, objectError, ...objectKey) {

    setTimeout(() => {

        objectError['error'] = false;

        clearDataArray = [];

        for (let i = 0; i < objectKey.length; i++) {
            objectError[i] = false;
        }

    }, 7000);

}

export const CONFIG_URLS = {

    LOGIN_URL: '/api/auth/login',
    REGISTER_URL: '/api/auth/register',
    GET_ADMINS_URL: '/api/admins',
    GET_PERSONAL_URL: '/api/personal',
    ADD_FIELD_URL: '/api/field',

};