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
    { path: '/thesisEdit/:id', name:'thesisEdit', component: require('../components/Thesis/ThesisEdit.vue').default },
    { path: '/books', component: require('../components/Books/Books.vue').default },
    { path: '/bookEdit/:id', name:'bookEdit', component: require('../components/Books/BookEdit.vue').default },
    { path: '/rewards', component: require('../components/Rewards/Reward.vue').default },
    { path: '/rewardEdit/:id', name:'rewardEdit', component: require('../components/Rewards/RewardEdit.vue').default },
    { path: '/courses', component: require('../components/Courses/Courses.vue').default },
    { path: '/courseEdit/:id', name:'courseEdit', component: require('../components/Courses/CourseEdit.vue').default },
    { path: '/teds', component: require('../components/TEDs/TEDs.vue').default },
    { path: '/tedEdit/:id', name:'tedEdit', component: require('../components/TEDs/TEDEdit.vue').default },
    { path: '/projects', component: require('../components/Projects/Projects.vue').default },
    { path: '/projectEdit/:id', name:'projectEdit', component: require('../components/Projects/ProjectEdit.vue').default },
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
