<template>
    <CrudTable
        title="Orders"
        endpoint="/api/orders"
        :columns="columns"
        :fields="fields"
        :on-change="handleChange"
        @saved="loadProducts"
    />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import CrudTable from '../components/CrudTable.vue';

const statuses = ['placed', 'processing', 'shipped', 'completed', 'cancelled'];

const columns = [
    { key: 'order_code', label: 'Order #' },
    { key: 'customer.name', label: 'Customer' },
    { key: 'product.product_name', label: 'Product' },
    { key: 'order_quantity', label: 'Qty' },
    { key: 'status', label: 'Status' },
];

const customers = ref([]);
const products = ref([]);
const customerOptions = ref([]);
const productOptions = ref([]);

const fields = computed(() => [
    { key: 'customer_id', label: 'Customer', options: customerOptions.value, searchable: true },
    { key: 'product_id', label: 'Product', options: productOptions.value, searchable: true },
    { key: 'order_quantity', label: 'Quantity', type: 'number' },
    { key: 'address', label: 'Address' },
    { key: 'contact_number', label: 'Contact Number' },
    { key: 'status', label: 'Status', default: 'placed', options: statuses.map((s) => ({ value: s, label: s })) },
]);

// Selecting a customer fills in their address & contact number.
function handleChange(key, value, formData) {
    if (key !== 'customer_id') return;
    const customer = customers.value.find((c) => c.id === Number(value));
    if (!customer) return;
    formData.address = customer.address ?? '';
    formData.contact_number = customer.contact_number ?? '';
}

async function loadProducts() {
    const { data } = await window.axios.get('/api/products', { params: { per_page: 1000 } });
    products.value = data.data ?? data;
    productOptions.value = products.value.map((p) => ({
        value: p.id,
        label: `${p.product_name} (${p.quantity} in stock)`,
    }));
}

async function loadCustomers() {
    const { data } = await window.axios.get('/api/customers', { params: { per_page: 1000 } });
    customers.value = data.data ?? data;
    customerOptions.value = customers.value.map((c) => ({
        value: c.id,
        label: `${c.customer_code} — ${c.name}`,
    }));
}

onMounted(() => Promise.all([loadCustomers(), loadProducts()]));
</script>
