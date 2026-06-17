<template>
    <div class="dash">
        <div class="cards">
            <div v-for="c in cards" :key="c.key" class="stat card">
                <span class="stat-ico" :style="{ background: c.tint }" v-html="c.icon" />
                <div>
                    <div class="stat-num">{{ counts[c.key] ?? '—' }}</div>
                    <div class="stat-label">{{ c.label }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive } from 'vue';

const box = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>';
const cart = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';
const contact = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>';
const users = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>';

const cards = [
    { key: 'inventory', label: 'Inventory Items', icon: box, tint: 'rgba(79,70,229,0.12)' },
    { key: 'orders', label: 'Orders', icon: cart, tint: 'rgba(16,163,74,0.12)' },
    { key: 'customers', label: 'Customers', icon: contact, tint: 'rgba(225,29,72,0.12)' },
    { key: 'employees', label: 'Employees', icon: users, tint: 'rgba(234,179,8,0.15)' },
];
const counts = reactive({});

onMounted(async () => {
    for (const c of cards) {
        try {
            const { data } = await window.axios.get(`/api/${c.key}`);
            counts[c.key] = data.total ?? (data.data ?? data).length;
        } catch { counts[c.key] = '—'; }
    }
});
</script>

<style scoped>
.cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
.stat { display: flex; align-items: center; gap: 1rem; padding: 1.25rem; }
.stat-ico { width: 44px; height: 44px; border-radius: 11px; display: grid; place-items: center; color: var(--primary); }
.stat-num { font-size: 1.6rem; font-weight: 700; letter-spacing: -0.02em; }
.stat-label { color: var(--text-muted); font-size: 0.82rem; }
</style>
