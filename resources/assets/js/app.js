/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import {routes, authLink} from './routes.js';
import {CONFIG_URLS} from './utils/other.js';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('homePage', require('./pages/home.vue'));

function chekAuthRoute(page = null) {
// TODO метод должен отправлять каждый раз токен на сервер. Получать ответ и обработывать его.
// Ипспользуем промисы В качеиве парамертра передаем ссылку на страницу

    // делаем асинхроный запрос синхроным.
    // так как хуй знает как рпавильно будет проверять токен
    // судя по логике проверяем токен. Если такой есть. Окей - иди дальше
    // нет на регистрацию или 404

    let currentPage = page;

    $.ajax({
        url: `${CONFIG_URLS.GET_AUTH_USER}?token=${localStorage.modernToken}`,
        async: false,
    }).done(() => {
        currentPage = page;
    }).fail(() => {
        if(authLink[page]) {
            currentPage = `login`
        }
    });

    return currentPage;
}

const app = new Vue({
    el: '#app',
    data: {
        currentRoute: window.location.pathname,
    },
    computed: {
        viewComputed () {
            const matchingView = routes[this.currentRoute];
            return matchingView
                ? require('./pages/' + chekAuthRoute(matchingView)+ '.vue')
                : require('./pages/404.vue')
        }
    },
    render (h) {
        return h(this.viewComputed);
    }
});

// window.addEventListener('popstate', () = > {
//     app.currentRoute = window.location.pathname;
// })
