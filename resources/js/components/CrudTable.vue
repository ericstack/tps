<template>
    <div class="crud">
        <div class="crud-head">
            <h2>{{ title }}</h2>
            <button @click="openCreate">+ New</button>
        </div>

        <p v-if="error" class="error">{{ error }}</p>

        <table v-if="rows.length">
            <thead>
                <tr>
                    <th v-for="col in columns" :key="col.key">{{ col.label }}</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in rows" :key="row.id">
                    <td v-for="col in columns" :key="col.key">{{ resolve(row, col.key) }}</td>
                    <td class="actions">
                        <button @click="openEdit(row)">Edit</button>
                        <button class="danger" @click="destroy(row)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <p v-else class="empty">No records yet.</p>

        <div v-if="showForm" class="modal-backdrop" @click.self="showForm = false">
            <form class="modal" @submit.prevent="save">
                <h3>{{ editing ? 'Edit' : 'New' }} {{ title }}</h3>
                <label v-for="f in fields" :key="f.key">
                    <span>{{ f.label }}</span>
                    <select v-if="f.options" v-model="formData[f.key]">
                        <option v-for="opt in f.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
                    </select>
                    <input v-else v-model="formData[f.key]" :type="f.type || 'text'" />
                </label>
                <div class="modal-actions">
                    <button type="button" @click="showForm = false">Cancel</button>
                    <button type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    title: { type: String, required: true },
    endpoint: { type: String, required: true }, // e.g. /api/inventory
    columns: { type: Array, required: true },    // [{ key, label }]
    fields: { type: Array, required: true },     // [{ key, label, type?, options? }]
});

const rows = ref([]);
const error = ref('');
const showForm = ref(false);
const editing = ref(null);
const formData = ref({});

function resolve(row, key) {
    return key.split('.').reduce((acc, part) => acc?.[part], row);
}

async function load() {
    try {
        const { data } = await window.axios.get(props.endpoint);
        rows.value = data.data ?? data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load data.';
    }
}

function openCreate() {
    editing.value = null;
    formData.value = {};
    showForm.value = true;
}

function openEdit(row) {
    editing.value = row;
    formData.value = { ...row };
    showForm.value = true;
}

async function save() {
    error.value = '';
    try {
        if (editing.value) {
            await window.axios.put(`${props.endpoint}/${editing.value.id}`, formData.value);
        } else {
            await window.axios.post(props.endpoint, formData.value);
        }
        showForm.value = false;
        await load();
    } catch (e) {
        error.value = e.response?.data?.message || 'Save failed.';
    }
}

async function destroy(row) {
    if (!confirm('Delete this record?')) return;
    await window.axios.delete(`${props.endpoint}/${row.id}`);
    await load();
}

onMounted(load);
</script>

<style scoped>
.crud-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
table { width: 100%; border-collapse: collapse; background: #fff; }
th, td { padding: .6rem; border-bottom: 1px solid #eee; text-align: left; }
.actions { display: flex; gap: .5rem; }
button { padding: .4rem .8rem; border: none; border-radius: 4px; background: #367fa9; color: #fff; cursor: pointer; }
button.danger { background: #dd4b39; }
.error { color: #dd4b39; }
.empty { color: #777; }
.modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.4); display: flex; align-items: center; justify-content: center; }
.modal { background: #fff; padding: 1.5rem; border-radius: 6px; width: 400px; display: flex; flex-direction: column; gap: .75rem; }
.modal label { display: flex; flex-direction: column; gap: .25rem; font-size: .9rem; }
.modal input, .modal select { padding: .5rem; border: 1px solid #ccc; border-radius: 4px; }
.modal-actions { display: flex; justify-content: flex-end; gap: .5rem; margin-top: .5rem; }
</style>
