export function clearData(clearDataArray, objectError, ...objectKey) {

    setTimeout(() => {

        objectError['error'] = false;

        clearDataArray = [];

        for (let i = 0; i < objectKey.length; i++) {
            objectError[i] = false;
        }

    }, 7000);

}