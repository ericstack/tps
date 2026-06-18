import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const routes = [
    { path: '/login', name: 'login', component: () => import('../pages/Login.vue'), meta: { guest: true } },
    {
        path: '/',
        component: () => import('../layouts/AppLayout.vue'),
        meta: { auth: true },
        children: [
            { path: '', name: 'dashboard', component: () => import('../pages/Dashboard.vue') },
            { path: 'inventory', name: 'inventory', component: () => import('../pages/Inventory.vue'), meta: { module: 'inventory_products' } },
            { path: 'products', name: 'products', component: () => import('../pages/Products.vue'), meta: { module: 'inventory_products' } },
            { path: 'customers', name: 'customers', component: () => import('../pages/Customers.vue') },
            { path: 'employees', name: 'employees', component: () => import('../pages/Employees.vue') },
            { path: 'orders', name: 'orders', component: () => import('../pages/Orders.vue'), meta: { module: 'orders' } },
            { path: 'tasks', name: 'tasks', component: () => import('../pages/Tasks.vue') },
            { path: 'deliveries', name: 'deliveries', component: () => import('../pages/Deliveries.vue'), meta: { module: 'deliveries' } },
            { path: 'purchase-orders', name: 'purchase-orders', component: () => import('../pages/PurchaseOrders.vue'), meta: { module: 'purchase_orders' } },
            { path: 'users', name: 'users', component: () => import('../pages/Users.vue'), meta: { admin: true } },
            { path: 'change-password', name: 'change-password', component: () => import('../pages/ChangePassword.vue') },
            { path: 'profile', name: 'profile', component: () => import('../pages/Profile.vue') },
            { path: 'settings', name: 'settings', component: () => import('../pages/Settings.vue') },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to) => {
    const auth = useAuthStore();

    if (auth.user === null) {
        await auth.fetchUser();
    }

    if (to.meta.auth && !auth.isAuthenticated) {
        return { name: 'login' };
    }
    if (to.meta.guest && auth.isAuthenticated) {
        return { name: 'dashboard' };
    }
    // A provisioned account with a temp password is trapped on change-password
    // until it sets a new one.
    if (auth.isAuthenticated && auth.mustChangePassword && to.name !== 'change-password') {
        return { name: 'change-password' };
    }
    if (to.meta.module && !auth.can(to.meta.module)) {
        return { name: 'dashboard' };
    }
    if (to.meta.admin && !auth.isAdmin) {
        return { name: 'dashboard' };
    }
});

export default router;
