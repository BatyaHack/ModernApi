
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import routes from './routes.js';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('homePage', require('./pages/home.vue'));

const app = new Vue({
    el: '#app',
    // data: {
    //     currentRoute: window.location.pathname,
    // },
    // computed: {
    //     viewComputed () {
    //         // const matchingView = routes[this.currentRoute];
    //         // return matchingView
    //         //     ? require('./pages/' + matchingView + '.vue')
    //         //     : require('./pages/404.vue')
    //
    //         //require('./pages/login.vue');
    //     }
    // },
    // render (h) {
    //     return h(require('./pages/login.vue'));
    // }
});

// window.addEventListener('popstate', () => {
//     app.currentRoute = window.location.pathname;
// });
