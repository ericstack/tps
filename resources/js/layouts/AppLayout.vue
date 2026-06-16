<template>
    <div class="layout">
        <aside class="sidebar">
            <h1 class="brand">TPS</h1>
            <nav>
                <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
                <router-link :to="{ name: 'inventory' }">Inventory</router-link>
                <router-link :to="{ name: 'products' }">Products</router-link>
                <router-link :to="{ name: 'customers' }">Customers</router-link>
                <router-link :to="{ name: 'employees' }">Employees</router-link>
                <router-link :to="{ name: 'orders' }">Orders</router-link>
                <router-link :to="{ name: 'tasks' }">Tasks</router-link>
                <router-link :to="{ name: 'deliveries' }">Deliveries</router-link>
                <router-link :to="{ name: 'purchase-orders' }">Purchase Orders</router-link>
                <router-link v-if="auth.isAdmin" :to="{ name: 'users' }">Users</router-link>
            </nav>
        </aside>
        <div class="main">
            <header class="topbar">
                <span>{{ auth.user?.name }}</span>
                <button @click="logout">Logout</button>
            </header>
            <main class="content">
                <router-view />
            </main>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const router = useRouter();

async function logout() {
    await auth.logout();
    router.push({ name: 'login' });
}
</script>

<style scoped>
.layout { display: flex; min-height: 100vh; font-family: system-ui, sans-serif; }
.sidebar { width: 220px; background: #1f2d3d; color: #fff; padding: 1rem; }
.brand { font-size: 1.5rem; margin-bottom: 1rem; }
.sidebar nav { display: flex; flex-direction: column; gap: .25rem; }
.sidebar a { color: #c2c7d0; text-decoration: none; padding: .5rem; border-radius: 4px; }
.sidebar a.router-link-active { background: #367fa9; color: #fff; }
.main { flex: 1; display: flex; flex-direction: column; }
.topbar { display: flex; justify-content: flex-end; gap: 1rem; align-items: center; padding: 1rem; background: #fff; border-bottom: 1px solid #ddd; }
.content { padding: 1.5rem; background: #ecf0f5; flex: 1; }
</style>
