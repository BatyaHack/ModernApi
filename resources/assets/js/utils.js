/**
 * Created by GoldGym on 01.10.2017.
 */

export function resetProperty(time, value = false, propery) {
    setTimeout(() => {
        propery[0] = false;
        propery[1] = false;
    }, time);
}
