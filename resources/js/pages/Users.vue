<template>
    <CrudTable title="Users" endpoint="/api/users" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'name', label: 'Name' },
    { key: 'username', label: 'Username' },
    { key: 'access', label: 'Access' },
    { key: 'active', label: 'Active' },
];
const fields = [
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
    { key: 'assign', label: 'Assignment' },
];
</script>
