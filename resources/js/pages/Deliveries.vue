<template>
    <CrudTable title="Deliveries" endpoint="/api/deliveries" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'order.order_code', label: 'Order #' },
    { key: 'customer_name', label: 'Customer' },
    { key: 'employee.employee_name', label: 'Driver' },
    { key: 'status', label: 'Status' },
];
const fields = [
    { key: 'order_id', label: 'Order ID', type: 'number' },
    { key: 'customer_name', label: 'Customer Name' },
    { key: 'address', label: 'Address' },
    { key: 'employee_id', label: 'Employee ID', type: 'number' },
    { key: 'status', label: 'Status (0/1)', type: 'number' },
];
</script>
