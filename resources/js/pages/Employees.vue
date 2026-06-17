<template>
    <CrudTable title="Employees" endpoint="/api/employees" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const positions = ['Driver', 'Warehouse Staff', 'Manager', 'Clerk', 'Supervisor', 'Dispatcher'];

const columns = [
    { key: 'employee_code', label: 'Code' },
    { key: 'employee_name', label: 'Name' },
    { key: 'position', label: 'Position' },
    { key: 'gender', label: 'Gender' },
    { key: 'birthday', label: 'Birthday', format: formatDate },
];

// Format an ISO/date string as MM/DD/YYYY without timezone drift.
function formatDate(value) {
    const [y, m, d] = String(value).slice(0, 10).split('-');
    return y && m && d ? `${m}/${d}/${y}` : value;
}
const fields = [
    { key: 'employee_code', label: 'Employee Code' },
    { key: 'employee_name', label: 'Name' },
    { key: 'position', label: 'Position', options: positions.map((p) => ({ value: p, label: p })) },
    { key: 'address', label: 'Address' },
    { key: 'gender', label: 'Gender', options: [
        { value: 'Male', label: 'Male' },
        { value: 'Female', label: 'Female' },
    ] },
    { key: 'birthday', label: 'Birthday', type: 'date' },
];
</script>
