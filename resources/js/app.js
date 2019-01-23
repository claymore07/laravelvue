
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
require('./jquery.html5cvm.min');
require('./jquery.SimpleMask.min');

import moment from 'moment';
import jmoment from 'moment-jalaali';

import Swal from 'sweetalert2'
import VueProgressBar from 'vue-progressbar';
import { Form, HasError, AlertError } from 'vform';
import VueRouter from 'vue-router';
import Gate from "./Gate";

Vue.prototype.$gate = new Gate(window.user);

window.swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(VueRouter);

let routes = [
    { path: '/home', component: require('./components/Dashboard.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];

Vue.filter('upText', function (text) {
    return text.charAt(0).toUpperCase() + text.substr(1);
});
Vue.filter('myDate', function (created) {
    jmoment.loadPersian({dialect: 'persian-modern', usePersianDigits: true});
    return jmoment(created).format('jDo jMMMM jYYYY    ');
});
Vue.filter('faDigit', function (value) {
    if (!value) return '';
    value = value.toString();
    const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    return value
        .toString()
        .split('')
        .map(x => farsiDigits[x])
        .join('');
})
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '10px'
});
const router = new VueRouter({
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
    routes // short for `routes: routes`
});

//global Event handler for vue
let Fire = new Vue();
window.Fire =Fire;

Vue.component('pagination', require('./components/LaravelVuePagination').default);


//passport

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:{
        search:'',
        pageName:'داشبورد',
    },
    methods:{
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },500),
    }
});
