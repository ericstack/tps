<template>
    <CrudTable title="Employees" endpoint="/api/employees" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'employee_code', label: 'Code' },
    { key: 'employee_name', label: 'Name' },
    { key: 'gender', label: 'Gender' },
    { key: 'birthday', label: 'Birthday' },
];
const fields = [
    { key: 'employee_code', label: 'Employee Code' },
    { key: 'employee_name', label: 'Name' },
    { key: 'address', label: 'Address' },
    { key: 'gender', label: 'Gender' },
    { key: 'birthday', label: 'Birthday', type: 'date' },
];
</script>
