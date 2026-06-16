<template>
    <CrudTable title="Tasks" endpoint="/api/tasks" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'subject', label: 'Subject' },
    { key: 'employee.employee_name', label: 'Assigned To' },
    { key: 'due_date', label: 'Due' },
    { key: 'status', label: 'Status' },
];
const fields = [
    { key: 'subject', label: 'Subject' },
    { key: 'description', label: 'Description' },
    { key: 'assigned_date', label: 'Assigned Date', type: 'date' },
    { key: 'due_date', label: 'Due Date', type: 'date' },
    { key: 'employee_id', label: 'Employee ID', type: 'number' },
    { key: 'status', label: 'Status (0/1)', type: 'number' },
];
</script>
