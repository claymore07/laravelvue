
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
require('./jquery.html5cvm.min');
require('./jquery.SimpleMask.min');
//window.fileDownload = require('js-file-download');
import JsonExcel from 'vue-json-excel'

Vue.component('downloadExcel', JsonExcel)
var VueTruncate = require('vue-truncate-filter')
import VueApexCharts from 'vue-apexcharts'

Vue.component('apexchart', VueApexCharts)
import User from './Helpers/User';
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
import router from './Router/router'
import Gate from "./Helpers/Gate";
import VueTheMask from 'vue-the-mask'
import PrettyCheckbox from 'pretty-checkbox-vue';
import VoerroTagsInput from '@voerro/vue-tagsinput';
import bTooltip from 'bootstrap-vue/es/components/tooltip/tooltip'
import bTooltipDirective from 'bootstrap-vue/es/directives/tooltip/tooltip'
import Loading from 'vue-loading-overlay';
import VueCurrencyFilter from 'vue-currency-filter'
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.prototype.$gate = new Gate(window.user);
window.User = User;





/** components include */
Vue.component('b-tooltip', bTooltip);
Vue.directive('b-tooltip', bTooltipDirective);
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('date-picker', VuePersianDatetimePicker);
Vue.component('tinymce', tinymce);
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
 * Eg.
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
window.moment = moment;
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
Vue.use(Loading, {
    // props
    loader:'bars',
    color: '#28D7AF',
    container: null,
    height:150,
    width: 150,
},{
    // slots
});

Vue.use(VueCurrencyFilter,
    {
        symbol : '',
        thousandsSeparator: ',',
        fractionCount: 2,
        fractionSeparator: '.',
        symbolPosition: 'back',
        symbolSpacing: true
    });

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
    if (!value) return '۰';
    value = value.toString();
    const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return value
        .toString()
        .split('')
        .map(x => farsiDigits[x])
        .join('');
});
Vue.filter('faDigits', function (value) {
    if (!value) return '۰';
    value = value.toString().split(".");
    var x =[];
    const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    x[0]= value[0]
        .toString()
        .split('')
        .map(x => farsiDigits[x])
        .join('');
    if(value.length>1){
        x[1]= value[1]
            .toString()
            .split('')
            .map(x => farsiDigits[x])
            .join('');
    }
        return x.toString();

});
Vue.filter('upText', function (text) {
    return text.charAt(0).toUpperCase() + text.substr(1);
});
Vue.filter('myDate', function (created) {
    if (!created) return '';
    var faDate;
    jmoments.loadPersian({usePersianDigits: true});
    faDate = jmoments(created).local('fa').format('jYYYY/jM/jD    ');
    jmoments.loadPersian({usePersianDigits: false});
    return faDate;
});
Vue.filter('myDateEN', function (created) {
    if (!created) return '';
  //  jmoment.loadPersian({ usePersianDigits: false});
    return jmoments(created).format('YYYY/M/D');
});
//jmoment.loadPersian({dialect: 'persian-modern', usePersianDigits: false});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
router.beforeEach((to, from, next) => {
    console.log(User.hasProfile())
    if(!User.hasProfile()){
        if(to.fullPath === '/profile' || to.fullPath === '/logout'|| to.fullPath === '/login'|| to.fullPath === '/signup'|| to.fullPath === '/'){
            next()
        }else{
            next('/profile')
        }
    }else{

        next()
    }
});
const app = new Vue({
    el: '#app',
    router,
    data:{
        search:'',
        pageName:'داشبورد',
        is_loggedIn: false,
        active_menu: 0,
        window: {
            width: 0,
            height: 0
        }
    },
    methods:{
        searchit: _.debounce(() => {

            Fire.$emit('searching');
        },1000),
        loggedIn(){
            this.is_loggedIn =  User.loggedIn();
        },
        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
            if(window.innerWidth > 992 && window.innerWidth < 1240){
                document.getElementById('body1').classList.add('sidebar-collapse')
            }else if(window.innerWidth >= 1240){
                document.getElementById('body1').classList.remove('sidebar-collapse')
            }
        }
    },
    computed:{
        photo(){
            if(User.photo() === 'profile.png'){
                return "/img/"+User.photo();
            }else{
                return "/img/profile/"+User.photo();
            }
        },
        name(){
            return User.name();
        },
        type(){
            return User.type();
        },

    },
    created(){

        window.addEventListener('resize', this.handleResize)
        this.handleResize();
        this.loggedIn();
        if(User.loggedIn()){
           // this.$router.push('/home');

        }else{
            this.$router.push('/');
        }
    }
});
