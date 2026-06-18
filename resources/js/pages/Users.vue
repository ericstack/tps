<template>
    <CrudTable title="Users" endpoint="/api/users" :columns="columns" :fields="fields" />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'name', label: 'Name' },
    { key: 'username', label: 'Username' },
    { key: 'access', label: 'Access' },
    { key: 'active', label: 'Active' },
];

const employeeOptions = ref([]);

const fields = computed(() => [
    { key: 'name', label: 'Name' },
    { key: 'username', label: 'Username' },
    { key: 'password', label: 'Password', type: 'password' },
    {
        key: 'access',
        label: 'Access Level',
        options: [
            { value: 1, label: 'Admin' },
            { value: 2, label: 'User' },
        ],
    },
    { key: 'employee_id', label: 'Linked Employee', options: employeeOptions.value, searchable: true },
    { key: 'assign', label: 'Assignment' },
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
