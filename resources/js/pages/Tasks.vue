<template>
    <CrudTable title="Tasks" endpoint="/api/tasks" :columns="columns" :fields="fields" />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import CrudTable from '../components/CrudTable.vue';

const statuses = ['open', 'in progress', 'done'];

const columns = [
    { key: 'subject', label: 'Subject' },
    { key: 'employee.employee_name', label: 'Assigned To' },
    { key: 'due_date', label: 'Due' },
    { key: 'status', label: 'Status' },
];

const employeeOptions = ref([]);

const fields = computed(() => [
    { key: 'subject', label: 'Subject' },
    { key: 'description', label: 'Description' },
    { key: 'assigned_date', label: 'Assigned Date', type: 'date' },
    { key: 'due_date', label: 'Due Date', type: 'date' },
    { key: 'employee_id', label: 'Employee', options: employeeOptions.value, searchable: true },
    { key: 'status', label: 'Status', default: 'open', options: statuses.map((s) => ({ value: s, label: s })) },
]);

onMounted(async () => {
    const { data } = await window.axios.get('/api/employees', { params: { per_page: 1000 } });
    const employees = data.data ?? data;
    employeeOptions.value = employees.map((e) => ({
        value: e.id,
        label: `${e.employee_code} — ${e.employee_name}`,
    }));
});
</script>
