<template>
    <CrudTable title="Orders" endpoint="/api/orders" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'order_code', label: 'Order #' },
    { key: 'customer.name', label: 'Customer' },
    { key: 'product.product_name', label: 'Product' },
    { key: 'order_quantity', label: 'Qty' },
    { key: 'status', label: 'Status' },
];
const fields = [
    { key: 'order_code', label: 'Order Code' },
    { key: 'customer_id', label: 'Customer ID', type: 'number' },
    { key: 'product_id', label: 'Product ID', type: 'number' },
    { key: 'address', label: 'Address' },
    { key: 'contact_number', label: 'Contact Number' },
    { key: 'order_quantity', label: 'Quantity', type: 'number' },
    { key: 'status', label: 'Status' },
];
</script>
