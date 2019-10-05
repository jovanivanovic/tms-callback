import HomePage from '../components/home/HomePage'

import LoginPage from '../components/auth/LoginPage'

import AdminPage from '../components/admin/AdminPage'
import AdminListPage from '../components/admin/AdminListPage'
import AdminCallbackPage from '../components/admin/AdminCallbackPage'

export const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomePage,
    },
    {
        path: '/login',
        name: 'Login',
        component: LoginPage,
    },
    {
        path: '/admin',
        component: AdminPage,
        meta: { auth: true },
        children: [
            {
                name: 'AdminList',
                path: '',
                component: AdminListPage,
                meta: { auth: true },
            },
            {
                name: 'AdminCallback',
                path: ':id',
                component: AdminCallbackPage,
                meta: { auth: true },
            },
        ]
    }
];
