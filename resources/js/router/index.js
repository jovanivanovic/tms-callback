import Vue from 'vue'
import Router from 'vue-router'
import { routes } from './routes'
import { Axios } from "../helpers/axios";
import store from "../store";

Vue.use(Router);

const router = new Router({
    mode: 'history',
    linkExactActiveClass: 'active',
    linkActiveClass: 'active',
    routes
});

// router.beforeEach((to, from, next) => {
//     store.commit('check');
//     const currentUser = store.state.users.current_user;
//
//     if (!currentUser) {
//         Axios.get('/api/auth/check')
//             .then((response) => {
//                 let status = response.data.message;
//
//                 if (status) {
//                     next();
//                 } else {
//                     store.commit('check');
//                     // store.commit('logout');
//                     next('/login');
//                 }
//             })
//             .catch((err) => {
//                 console.log(err);
//             })
//     }
//     next();
// });

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.auth);
    const currentUser = store.state.users.current_user;

    if (requiresAuth && !currentUser) {
        next('/login');
    } else if (to.path === '/login' && currentUser) {
        next('/');
    } else {
        next();
    }
});

Vue.router = router;

export default router
