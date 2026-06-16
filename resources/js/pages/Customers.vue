<template>
    <CrudTable title="Customers" endpoint="/api/customers" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'customer_code', label: 'Code' },
    { key: 'name', label: 'Name' },
    { key: 'address', label: 'Address' },
    { key: 'contact_number', label: 'Contact' },
];
const fields = [
    { key: 'customer_code', label: 'Customer Code' },
    { key: 'name', label: 'Name' },
    { key: 'address', label: 'Address' },
    { key: 'contact_number', label: 'Contact Number' },
];
</script>
