<template>
    <CrudTable
        title="Inventory"
        endpoint="/api/inventory"
        :columns="columns"
        :fields="fields"
        :on-change="handleChange"
    />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import CrudTable from '../components/CrudTable.vue';

const columns = [
    { key: 'serial_no', label: 'Serial No' },
    { key: 'name', label: 'Name' },
    { key: 'product.product_name', label: 'Product' },
    { key: 'quantity', label: 'Qty' },
    { key: 'category.name', label: 'Category' },
];

const products = ref([]);
const productOptions = ref([]);
const categoryOptions = ref([]);

// Auto-fill name & description from the chosen catalog product.
function handleChange(key, value, formData) {
    if (key !== 'product_id') return;
    const product = products.value.find((p) => p.id === Number(value));
    if (!product) return;
    formData.name = product.product_name;
    formData.description = product.description;
}

const fields = computed(() => [
    { key: 'product_id', label: 'Product', options: productOptions.value, searchable: true },
    { key: 'serial_no', label: 'Serial No' },
    { key: 'name', label: 'Name' },
    { key: 'description', label: 'Description' },
    { key: 'quantity', label: 'Quantity', type: 'number' },
    { key: 'category_id', label: 'Category', options: categoryOptions.value },
]);

onMounted(async () => {
    const [productsRes, categoriesRes] = await Promise.all([
        window.axios.get('/api/products', { params: { per_page: 1000 } }),
        window.axios.get('/api/categories', { params: { per_page: 1000 } }),
    ]);
    products.value = productsRes.data.data ?? productsRes.data;
    productOptions.value = products.value.map((p) => ({
        value: p.id,
        label: p.product_name,
    }));
    categoryOptions.value = (categoriesRes.data.data ?? categoriesRes.data).map((c) => ({
        value: c.id,
        label: c.name,
    }));
});
</script>
