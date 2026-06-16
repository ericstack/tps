<template>
    <CrudTable
        title="Inventory"
        endpoint="/api/inventory"
        :columns="columns"
        :fields="fields"
    />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'serial_no', label: 'Serial No' },
    { key: 'name', label: 'Name' },
    { key: 'quantity', label: 'Qty' },
    { key: 'category.name', label: 'Category' },
];
const fields = [
    { key: 'serial_no', label: 'Serial No' },
    { key: 'name', label: 'Name' },
    { key: 'description', label: 'Description' },
    { key: 'quantity', label: 'Quantity', type: 'number' },
    { key: 'category_id', label: 'Category ID', type: 'number' },
];
</script>
