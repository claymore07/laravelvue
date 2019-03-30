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
    { path: '/profile', component: require('../components/User/Profile.vue').default },
    { path: '/users', component: require('../components/User/Users.vue').default },
    { path: '/paperedit/:id', name:'paperedit',component: require('../components/Papers/PaperEdit.vue').default },
    { path: '/papers', component: require('../components/Papers/Papers.vue').default },
    { path: '/faculties', component: require('../components/Faculty/Faculties.vue').default },
    { path: '/departments', component: require('../components/Department/Departments.vue').default },
    { path: '/developer', component: require('../components/Developer.vue').default },
    { path: '/score', component: require('../components/Score/Scores.vue').default },
    { path: '/term', component: require('../components/Term/Terms.vue').default },
    { path: '/thesis', component: require('../components/Thesis/Thesis.vue').default },
    { path: '/thesisEdit/:id', name:'thesisEdit', component: require('../components/Thesis/ThesisEdit').default },
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
