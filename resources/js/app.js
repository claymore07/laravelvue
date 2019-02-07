
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
require('./jquery.html5cvm.min');
require('./jquery.SimpleMask.min');
var VueTruncate = require('vue-truncate-filter')
import moment from 'moment';
import jmoments from 'moment-jalaali';
import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
import tinymce from 'vue-tinymce-editor'
import VeeValidate from 'vee-validate';
import farsiMessage from 'vee-validate/dist/locale/fa';
import Swal from 'sweetalert2'
import VueProgressBar from 'vue-progressbar';
import { Form, HasError, AlertError } from 'vform';
import objectToFormData from "./objectToFormData";
import VueRouter from 'vue-router';
import Gate from "./Gate";
import VueTheMask from 'vue-the-mask'
import PrettyCheckbox from 'pretty-checkbox-vue';
import VoerroTagsInput from '@voerro/vue-tagsinput';
import bTooltip from 'bootstrap-vue/es/components/tooltip/tooltip'
import bTooltipDirective from 'bootstrap-vue/es/directives/tooltip/tooltip'
Vue.prototype.$gate = new Gate(window.user);

/** vue router */
Vue.use(VueRouter);
let routes = [
    { path: '/home', component: require('./components/Dashboard.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/paperedit/:id', name:'paperedit',component: require('./components/PaperEdit.vue').default },
    { path: '/papers', component: require('./components/Papers.vue').default },
    { path: '/faculties', component: require('./components/Faculties.vue').default },
    { path: '/departments', component: require('./components/Departments.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
];
const router = new VueRouter({
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
    routes // short for `routes: routes`
});


/** components include */
Vue.component('b-tooltip', bTooltip);
Vue.directive('b-tooltip', bTooltipDirective);
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('date-picker', VuePersianDatetimePicker);
Vue.component('tinymce', tinymce)
Vue.component('tags-input', VoerroTagsInput);
Vue.component('pagination', require('./components/LaravelVuePagination').default);
//Vue.component('farsijournalcomponent', require('./components/papers/FarsiJournalPaper').default);
//Vue.component('enjournalcomponent', require('./components/papers/EnJournalPaper').default);
Vue.component('not-found',require('./components/NotFound.vue').default);

/** Laravel passport components*/
Vue.component('passport-clients', require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/** global variables */
//global Event handler for vue
let Fire = new Vue();
window.Fire =Fire;

window.toast = toast;
window.objectToFormData = objectToFormData;
window.Form = Form;

Vue.use(PrettyCheckbox);
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '10px'
});

Vue.use(VeeValidate, {
    locale: 'fa',
    dictionary: {
        fa: { messages: farsiMessage }
    }
});

Vue.use(VueTruncate);
Vue.use(VueFormWizard);
Vue.use(VueTheMask);



window.swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
/** global vue mixin */
Vue.mixin({
    methods:{
        errorSwal:(msg)=>{
            swal.fire({
                title: 'خطا!',
                text: msg,
                type: 'error',
                confirmButtonText: 'متوجه شدم!',
            });
        },
        successSwal:(msg)=>{
            swal.fire({
                title: 'موفق',
                text: msg,
                type: 'success',
                confirmButtonText: 'متوجه شدم!',
            });
        },
        warningSwal:(msg)=>{
            swal.fire({
                title: 'لفو شد!',
                text: msg,
                type: 'warning',
                focusConfirm: true,
                confirmButtonText: 'متوجه شدم!',
            });
        },
        successToast:(msg)=>{
            toast({
                type: 'success',
                position: 'top-start',
                title: msg
            });
        },
        errorToast:(msg)=>{
            toast({
                type: 'error',
                position: 'top-start',
                title: msg
            });
        }
    }
});

/** filters */
Vue.filter('faDigit', function (value) {
    if (!value) return '';
    value = value.toString();
    const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return value
        .toString()
        .split('')
        .map(x => farsiDigits[x])
        .join('');
});
Vue.filter('upText', function (text) {
    return text.charAt(0).toUpperCase() + text.substr(1);
});
Vue.filter('myDate', function (created) {
    var faDate;
    jmoments.loadPersian({usePersianDigits: true});
    faDate = jmoments(created).local('fa').format('jYYYY/jM/jD    ');
    jmoments.loadPersian({usePersianDigits: false});
    return faDate;
});
Vue.filter('myDateEN', function (created) {
  //  jmoment.loadPersian({ usePersianDigits: false});
    return jmoments(created).format('YYYY/M/D');
});
//jmoment.loadPersian({dialect: 'persian-modern', usePersianDigits: false});
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
        user:window.user,
    },
    methods:{
        searchit: _.debounce(() => {

            Fire.$emit('searching');
        },500),
    }
});
