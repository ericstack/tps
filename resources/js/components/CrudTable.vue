<template>
    <div class="crud">
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="search">
                <span class="search-ico" v-html="searchIcon" />
                <input v-model="search" class="input search-input" :placeholder="`Search ${title.toLowerCase()}…`" />
                <button v-if="search" class="search-clear" @click="search = ''" aria-label="Clear">×</button>
            </div>

            <div class="toolbar-right">
                <button v-if="filterable.length" class="btn btn-ghost" @click="showFilters = !showFilters">
                    <span v-html="filterIcon" /> Filters
                    <span v-if="activeFilterCount" class="badge badge-primary">{{ activeFilterCount }}</span>
                </button>
                <button class="btn btn-primary" @click="openCreate">
                    <span v-html="plusIcon" /> New
                </button>
            </div>
        </div>

        <!-- Filter row -->
        <transition name="slide">
            <div v-if="showFilters && filterable.length" class="filters card">
                <div v-for="f in filterable" :key="f.key" class="filter-field">
                    <label>{{ f.label }}</label>
                    <select v-if="f.options" v-model="filters[f.key]" class="select">
                        <option value="">All</option>
                        <option v-for="opt in f.options" :key="opt.value" :value="String(opt.value)">{{ opt.label }}</option>
                    </select>
                    <input v-else v-model="filters[f.key]" class="input" :placeholder="`Filter by ${f.label.toLowerCase()}`" />
                </div>
                <button class="btn btn-ghost" @click="clearFilters">Clear all</button>
            </div>
        </transition>

        <p v-if="error" class="error">{{ error }}</p>

        <!-- Table -->
        <div class="table-wrap card">
            <table>
                <thead>
                    <tr>
                        <th v-for="col in columns" :key="col.key" @click="sortBy(col.key)" class="sortable">
                            {{ col.label }}
                            <span v-if="sortKey === col.key" class="sort-arrow">{{ sortDir === 'asc' ? '↑' : '↓' }}</span>
                        </th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in pageRows" :key="row.id">
                        <td v-for="col in columns" :key="col.key">{{ display(row, col.key) }}</td>
                        <td class="actions">
                            <button class="btn btn-ghost btn-icon" @click="openEdit(row)" aria-label="Edit"><span v-html="editIcon" /></button>
                            <button class="btn btn-danger-ghost btn-icon" @click="destroy(row)" aria-label="Delete"><span v-html="trashIcon" /></button>
                        </td>
                    </tr>
                    <tr v-if="!loading && !filtered.length">
                        <td :colspan="columns.length + 1" class="empty">
                            <div class="empty-state">
                                <span v-html="inboxIcon" />
                                <p>{{ search || activeFilterCount ? 'No matches for your search/filters.' : 'No records yet.' }}</p>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="loading">
                        <td :colspan="columns.length + 1" class="empty">Loading…</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div v-if="filtered.length" class="table-foot">
            <span class="count">{{ filtered.length }} {{ filtered.length === 1 ? 'record' : 'records' }}</span>
            <div class="pager" v-if="totalPages > 1">
                <button class="btn btn-ghost btn-icon" :disabled="page === 1" @click="page--">‹</button>
                <span>Page {{ page }} / {{ totalPages }}</span>
                <button class="btn btn-ghost btn-icon" :disabled="page === totalPages" @click="page++">›</button>
            </div>
        </div>

        <!-- Modal -->
        <transition name="fade">
            <div v-if="showForm" class="modal-backdrop" @click.self="showForm = false">
                <div class="modal card">
                    <div class="modal-head">
                        <h3>{{ editing ? 'Edit' : 'New' }} {{ singular }}</h3>
                        <button class="btn btn-ghost btn-icon" @click="showForm = false">×</button>
                    </div>
                    <form @submit.prevent="save" class="modal-body">
                        <label v-for="f in fields" :key="f.key" class="field">
                            <span>{{ f.label }}</span>
                            <select v-if="f.options" v-model="formData[f.key]" class="select">
                                <option v-for="opt in f.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
                            </select>
                            <input v-else v-model="formData[f.key]" :type="f.type || 'text'" class="input" />
                        </label>
                        <div class="modal-actions">
                            <button type="button" class="btn btn-ghost" @click="showForm = false">Cancel</button>
                            <button type="submit" class="btn btn-primary">{{ editing ? 'Save changes' : 'Create' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';

const props = defineProps({
    title: { type: String, required: true },
    endpoint: { type: String, required: true },
    columns: { type: Array, required: true },
    fields: { type: Array, required: true },
    // optional: which fields are exposed as column filters; defaults to fields with options
    filterKeys: { type: Array, default: null },
});

const rows = ref([]);
const error = ref('');
const loading = ref(true);
const search = ref('');
const showFilters = ref(false);
const filters = reactive({});
const sortKey = ref(null);
const sortDir = ref('asc');
const page = ref(1);
const pageSize = 10;

const showForm = ref(false);
const editing = ref(null);
const formData = ref({});

const singular = computed(() => props.title.replace(/s$/, ''));

const filterable = computed(() => {
    if (props.filterKeys) return props.fields.filter((f) => props.filterKeys.includes(f.key));
    return props.fields.filter((f) => f.options);
});

const activeFilterCount = computed(() => Object.values(filters).filter((v) => v !== '' && v != null).length);

function get(row, key) {
    return key.split('.').reduce((acc, part) => acc?.[part], row);
}
function display(row, key) {
    const v = get(row, key);
    return v == null ? '—' : v;
}

const filtered = computed(() => {
    let out = rows.value;
    const q = search.value.trim().toLowerCase();
    if (q) {
        out = out.filter((r) => props.columns.some((c) => String(get(r, c.key) ?? '').toLowerCase().includes(q)));
    }
    for (const f of filterable.value) {
        const val = filters[f.key];
        if (val === '' || val == null) continue;
        out = out.filter((r) => String(get(r, f.key) ?? '').toLowerCase() === String(val).toLowerCase());
    }
    if (sortKey.value) {
        out = [...out].sort((a, b) => {
            const av = get(a, sortKey.value), bv = get(b, sortKey.value);
            if (av == null) return 1;
            if (bv == null) return -1;
            const r = typeof av === 'number' && typeof bv === 'number' ? av - bv : String(av).localeCompare(String(bv));
            return sortDir.value === 'asc' ? r : -r;
        });
    }
    return out;
});

const totalPages = computed(() => Math.max(1, Math.ceil(filtered.value.length / pageSize)));
const pageRows = computed(() => {
    if (page.value > totalPages.value) page.value = totalPages.value;
    const start = (page.value - 1) * pageSize;
    return filtered.value.slice(start, start + pageSize);
});

function sortBy(key) {
    if (sortKey.value === key) sortDir.value = sortDir.value === 'asc' ? 'desc' : 'asc';
    else { sortKey.value = key; sortDir.value = 'asc'; }
}
function clearFilters() {
    for (const k of Object.keys(filters)) filters[k] = '';
}

async function load() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await window.axios.get(props.endpoint);
        rows.value = data.data ?? data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load data.';
    } finally {
        loading.value = false;
    }
}

function openCreate() { editing.value = null; formData.value = {}; showForm.value = true; }
function openEdit(row) { editing.value = row; formData.value = { ...row }; showForm.value = true; }

async function save() {
    error.value = '';
    try {
        if (editing.value) await window.axios.put(`${props.endpoint}/${editing.value.id}`, formData.value);
        else await window.axios.post(props.endpoint, formData.value);
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

/* icons */
const searchIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>';
const filterIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>';
const plusIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
const editIcon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>';
const trashIcon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>';
const inboxIcon = '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>';
</script>

<style scoped>
.crud { display: flex; flex-direction: column; gap: 1rem; }

.toolbar { display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; }
.search { position: relative; flex: 1; min-width: 220px; max-width: 420px; }
.search-ico { position: absolute; left: 0.7rem; top: 50%; transform: translateY(-50%); color: var(--text-faint); display: inline-flex; }
.search-input { padding-left: 2.2rem; }
.search-clear { position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); border: none; background: transparent; font-size: 1.2rem; color: var(--text-muted); cursor: pointer; line-height: 1; }
.toolbar-right { display: flex; gap: 0.6rem; margin-left: auto; }

.filters { padding: 1rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; }
.filter-field { display: flex; flex-direction: column; gap: 0.3rem; min-width: 180px; }
.filter-field label { font-size: 0.75rem; font-weight: 550; color: var(--text-muted); }

.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
    text-align: left; padding: 0.75rem 1rem; font-size: 0.72rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.04em; color: var(--text-muted);
    border-bottom: 1px solid var(--border); background: var(--surface-2); user-select: none;
}
thead th.sortable { cursor: pointer; }
thead th.sortable:hover { color: var(--text); }
.sort-arrow { color: var(--primary); }
.actions-col { text-align: right; }
tbody td { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); }
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover td { background: var(--surface-hover); }
.actions { display: flex; gap: 0.35rem; justify-content: flex-end; }

.empty { text-align: center; padding: 2.5rem 1rem; color: var(--text-muted); }
.empty-state { display: flex; flex-direction: column; align-items: center; gap: 0.6rem; color: var(--text-faint); }

.table-foot { display: flex; align-items: center; justify-content: space-between; }
.count { color: var(--text-muted); font-size: 0.82rem; }
.pager { display: flex; align-items: center; gap: 0.6rem; font-size: 0.82rem; color: var(--text-muted); }

.error { color: var(--danger); background: var(--danger-soft); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm); margin: 0; }

.modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; padding: 1rem; z-index: 100; }
.modal { width: 460px; max-width: 100%; max-height: 90vh; overflow: auto; }
.modal-head { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); }
.modal-body { padding: 1.25rem; display: flex; flex-direction: column; gap: 0.9rem; }
.field { display: flex; flex-direction: column; gap: 0.35rem; font-size: 0.82rem; font-weight: 550; color: var(--text-muted); }
.modal-actions { display: flex; justify-content: flex-end; gap: 0.6rem; margin-top: 0.4rem; }

.fade-enter-active, .fade-leave-active { transition: opacity 0.15s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.slide-enter-active, .slide-leave-active { transition: opacity 0.15s, transform 0.15s; }
.slide-enter-from, .slide-leave-to { opacity: 0; transform: translateY(-6px); }
</style>
