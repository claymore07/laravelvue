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
    { path: '/referees', component: require('../components/Referees/Referees.vue').default },
    { path: '/refereeEdit/:id', name:'refereeEdit', component: require('../components/Referees/RefereeEdit.vue').default },
    { path: '/inventions', component: require('../components/Inventions/Inventions.vue').default },
    { path: '/inventionEdit/:id', name:'inventionEdit', component: require('../components/Inventions/InventionEdit.vue').default },
    { path: '/booklets', component: require('../components/Booklets/Booklets.vue').default },
    { path: '/bookletEdit/:id', name:'bookletEdit', component: require('../components/Booklets/BookletEdit.vue').default },
    { path: '/grants', component: require('../components/Grants/Grants.vue').default },
    { path: '/grantEdit/:id', name:'grantEdit', component: require('../components/Grants/GrantEdit.vue').default },
    { path: '/paperReport', component: require('../components/Reports/PaperReport.vue').default },
    { path: '/bookReport', component: require('../components/Reports/BookReport.vue').default },
    { path: '/inventionReport', component: require('../components/Reports/InventionReport.vue').default },
    { path: '/projectReport', component: require('../components/Reports/ProjectReport.vue').default },
    { path: '/tedReport', component: require('../components/Reports/TEDReport.vue').default },
    { path: '/thesisReport', component: require('../components/Reports/ThesisReport.vue').default },
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
