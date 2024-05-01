import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
import CloudSync from '../components/pages/system/cloud-sync/CloudSync.vue';

const DefaultLayout = () => import('@/components/DefaultLayout.vue');
const AuthLayout = () => import('@/components/AuthLayout.vue');
const SettingsLayout = () => import('@/components/SettingsLayout.vue');
const Login = () => import('@/components/pages/auth/Login.vue');
const Register = () => import('@/components/pages/auth/Register.vue');
const Dashboard = () => import('@/components/pages/Dashboard.vue');

const Module = () => import ('@/components/pages/system/module/Module.vue');
const ModuleEdit = () => import ('@/components/pages/system/module/ModuleEdit.vue');

const User = () => import ('@/components/pages/system/User.vue');
const UserProfile = () => import ('@/components/pages/system/UserProfile.vue');
const Rol = () => import ('@/components/pages/system/Rol.vue');
const RolEdit = () => import ('@/components/pages/system/RolEdit.vue');

const Company = () => import ('@/components/pages/configuration/company/Company.vue');
const CompanyEdit = () => import ('@/components/pages/configuration/company/CompanyEdit.vue');

const routes = [
    {
        path: '/',
        redirect: '/dashboard',
        component: DefaultLayout,
        meta: {
            requiresAuth: true,
        },
        children: [
            { path: '/dashboard', name: 'Dashboard', component: Dashboard },
            { path: '/users', name: 'users', component: User },
            { path: '/user/:id', name: 'user', component: UserProfile },
            { 
                path: '/settings', 
                redirect: '/roles', 
                component: SettingsLayout,
                children: [
                    { path: '/roles', name: 'roles', component: Rol },
                    { path: '/rol/:id', name: 'rol', component: RolEdit },
                ] 
            },
            { path: '/modules', name: 'modules', component: Module },
            { path: '/module/:id', name: 'module', component: ModuleEdit },
            { path: '/companies', name: 'companies', component: Company },
            { path: '/company/:id', name: 'company', component: CompanyEdit },
            { path: '/cloud-sync', name: 'cloud-sync', component: CloudSync },
        ]
    },
    {
        path: '/auth',
        redirect: '/login',
        component: AuthLayout,
        meta: {
            isGuest: true,
        },
        children: [
            { path: '/login', name: 'Login', component: Login },
            { path: '/register', name: 'Register', component: Register },
        ]
    }
];

const router = createRouter({
    history: createWebHistory('/'),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'Login' });
    }
    else if (store.state.user.token && (to.meta.isGuest)) {
        next({ name: 'Dashboard' });
    }
    else next();
});

export default router;