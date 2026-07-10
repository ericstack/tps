<template>
    <CrudTable
        title="Deliveries"
        endpoint="/api/deliveries"
        :columns="columns"
        :fields="fields"
        :on-change="handleChange"
        :can-create="!auth.seesOnlyAssignedWork"
        :can-delete="!auth.seesOnlyAssignedWork"
    />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import CrudTable from '../components/CrudTable.vue';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();

const columns = [
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
    // Order # is derived from the linked order; shown read-only when editing.
    { key: 'order_code', label: 'Order #', editOnly: true, readonly: true },
    // Pick the order only when creating; on edit it's shown read-only as Order # above.
    { key: 'order_id', label: 'Order', options: orderOptions.value, searchable: true, createOnly: true },
    // Customer/address derive from the chosen order — never hand-edited.
    { key: 'customer_name', label: 'Customer Name', readonly: true },
    { key: 'address', label: 'Delivery Address', readonly: true },
    // Driver is assigned at creation only; hidden from the edit modal.
    { key: 'employee_id', label: 'Employee ID', type: 'number', createOnly: true },
    // Status is the only thing editable once a delivery exists.
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
