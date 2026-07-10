import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const routes = [
    { path: '/login', name: 'login', component: () => import('../pages/Login.vue'), meta: { guest: true } },
    {
        path: '/',
        component: () => import('../layouts/AppLayout.vue'),
        meta: { auth: true },
        children: [
            { path: '', name: 'dashboard', component: () => import('../pages/Dashboard.vue'), meta: { hide: 'dashboard' } },
            { path: 'inventory', name: 'inventory', component: () => import('../pages/Inventory.vue'), meta: { module: 'inventory_products' } },
            { path: 'products', name: 'products', component: () => import('../pages/Products.vue'), meta: { module: 'inventory_products' } },
            { path: 'customers', name: 'customers', component: () => import('../pages/Customers.vue'), meta: { hide: 'customers' } },
            { path: 'employees', name: 'employees', component: () => import('../pages/Employees.vue'), meta: { hide: 'employees' } },
            { path: 'orders', name: 'orders', component: () => import('../pages/Orders.vue'), meta: { module: 'orders' } },
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

// The post-login landing page: Dashboard, unless the role hides it (e.g. field
// deliveries staff), in which case fall back to their first accessible module.
function landingRoute(auth) {
    if (!auth.isHidden('dashboard')) return { name: 'dashboard' };
    const candidates = [
        { name: 'deliveries', module: 'deliveries' },
        { name: 'orders', module: 'orders' },
        { name: 'inventory', module: 'inventory_products' },
        { name: 'purchase-orders', module: 'purchase_orders' },
        { name: 'customers', hide: 'customers' },
        { name: 'employees', hide: 'employees' },
    ];
    const home = candidates.find(
        (c) => (!c.module || auth.can(c.module)) && !(c.hide && auth.isHidden(c.hide)),
    );
    return { name: home?.name || 'change-password' };
}

router.beforeEach(async (to) => {
    const auth = useAuthStore();

    if (auth.user === null) {
        await auth.fetchUser();
    }

    if (to.meta.auth && !auth.isAuthenticated) {
        return { name: 'login' };
    }
    if (to.meta.guest && auth.isAuthenticated) {
        return landingRoute(auth);
    }
    // A provisioned account with a temp password is trapped on change-password
    // until it sets a new one.
    if (auth.isAuthenticated && auth.mustChangePassword && to.name !== 'change-password') {
        return { name: 'change-password' };
    }
    if (to.meta.module && !auth.can(to.meta.module)) {
        return landingRoute(auth);
    }
    if (to.meta.hide && auth.isHidden(to.meta.hide)) {
        return landingRoute(auth);
    }
    if (to.meta.admin && !auth.isAdmin) {
        return landingRoute(auth);
    }
});

export default router;
