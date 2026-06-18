<template>
    <CrudTable
        title="Deliveries"
        endpoint="/api/deliveries"
        :columns="columns"
        :fields="fields"
        :on-change="handleChange"
    />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'id', label: 'ID' },
    { key: 'control_number', label: 'Control #' },
    { key: 'order.order_code', label: 'Order #' },
    { key: 'customer_name', label: 'Customer' },
    { key: 'employee.employee_name', label: 'Driver' },
    { key: 'status', label: 'Status' },
];

const statuses = ['pending', 'in transit', 'delivered', 'failed'];

const orders = ref([]);
const orderOptions = ref([]);

const fields = computed(() => [
    { key: 'order_id', label: 'Order', options: orderOptions.value, searchable: true },
    { key: 'customer_name', label: 'Customer Name' },
    { key: 'address', label: 'Delivery Address' },
    { key: 'employee_id', label: 'Employee ID', type: 'number' },
    { key: 'status', label: 'Status', default: 'pending', options: statuses.map((s) => ({ value: s, label: s })) },
]);

// Selecting an order fills in the customer name and delivery address from that order.
function handleChange(key, value, formData) {
    if (key !== 'order_id') return;
    const order = orders.value.find((o) => o.id === Number(value));
    if (!order) return;
    formData.customer_name = order.customer?.name ?? '';
    formData.address = order.address ?? '';
}

onMounted(async () => {
    const { data } = await window.axios.get('/api/orders', { params: { per_page: 1000 } });
    orders.value = data.data ?? data;
    orderOptions.value = orders.value.map((o) => ({
        value: o.id,
        label: `${o.order_code} — ${o.customer?.name ?? 'Unknown'}`,
    }));
});
</script>
