<template>
    <div>
        <h2>Dashboard</h2>
        <div class="cards">
            <div v-for="c in cards" :key="c.label" class="card">
                <span class="num">{{ counts[c.key] ?? '—' }}</span>
                <span class="label">{{ c.label }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive } from 'vue';

const cards = [
    { key: 'inventory', label: 'Inventory Items' },
    { key: 'orders', label: 'Orders' },
    { key: 'customers', label: 'Customers' },
    { key: 'employees', label: 'Employees' },
];
const counts = reactive({});

onMounted(async () => {
    for (const c of cards) {
        try {
            const { data } = await window.axios.get(`/api/${c.key}`);
            counts[c.key] = data.total ?? (data.data ?? data).length;
        } catch {
            counts[c.key] = '—';
        }
    }
});
</script>

<style scoped>
.cards { display: flex; gap: 1rem; flex-wrap: wrap; }
.card { background: #fff; padding: 1.5rem; border-radius: 6px; min-width: 160px; display: flex; flex-direction: column; }
.num { font-size: 2rem; font-weight: 700; color: #367fa9; }
.label { color: #777; }
</style>
