<template>
    <CrudTable title="Purchase Orders" endpoint="/api/purchase-orders" :columns="columns" :fields="fields" />
</template>

<script setup>
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'po_no', label: 'PO #' },
    { key: 'supplier', label: 'Supplier' },
    { key: 'order_date', label: 'Date' },
    { key: 'total', label: 'Total' },
    { key: 'payment_status', label: 'Payment' },
];
const fields = [
    { key: 'po_no', label: 'PO Number' },
    { key: 'supplier', label: 'Supplier' },
    { key: 'order_date', label: 'Order Date', type: 'date' },
    { key: 'total', label: 'Total', type: 'number' },
    {
        key: 'payment_status',
        label: 'Payment Status',
        options: [
            { value: 'unpaid', label: 'Unpaid' },
            { value: 'partial', label: 'Partial' },
            { value: 'paid', label: 'Paid' },
        ],
    },
];
</script>
