<template>
    <CrudTable title="Products" endpoint="/api/products" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'product_code', label: 'Code' },
    { key: 'product_name', label: 'Name' },
    { key: 'quantity', label: 'Qty' },
];
const fields = [
    { key: 'product_code', label: 'Product Code' },
    { key: 'product_name', label: 'Product Name' },
    { key: 'description', label: 'Description' },
    { key: 'quantity', label: 'Quantity', type: 'number' },
];
</script>
