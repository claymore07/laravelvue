import Vue from 'vue'
import VueRouter from 'vue-router';
/** vue router */
Vue.use(VueRouter);
let routes = [
    { path: '/', component: require('../components/auth/welcome').default },
    { path: '/home', component: require('../components/Dashboard.vue').default },
    { path: '/login', component: require('../components/auth/Login.vue').default },
    { path: '/logout', component: require('../components/auth/Logout.vue').default },
    { path: '/signup', component: require('../components/auth/Signup.vue').default },
    { path: '/dashboard', component: require('../components/Dashboard.vue').default },
    { path: '/profile', component: require('../components/Profile.vue').default },
    { path: '/users', component: require('../components/Users.vue').default },
    { path: '/paperedit/:id', name:'paperedit',component: require('../components/PaperEdit.vue').default },
    { path: '/papers', component: require('../components/Papers.vue').default },
    { path: '/faculties', component: require('../components/Faculties.vue').default },
    { path: '/departments', component: require('../components/Departments.vue').default },
    { path: '/developer', component: require('../components/Developer.vue').default },
    { path: '/score', component: require('../components/Scores.vue').default },
    { path: '/term', component: require('../components/Terms.vue').default },
    { path: '/notready', component: require('../components/NotFound.vue').default },
    { path: '/*', component: require('../components/NotFound.vue').default },
];

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
    routes // short for `routes: routes`
});

export default router
