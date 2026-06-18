<template>
    <CrudTable ref="table" title="Users" endpoint="/api/users" :columns="columns" :fields="fields">
        <template #toolbar>
            <button class="btn btn-ghost" @click="openProvision">
                <span v-html="keyIcon" /> Provision login
            </button>
        </template>

        <!-- Provision-from-employee modal -->
        <transition name="fade">
            <div v-if="provisionOpen" class="modal-backdrop" @click.self="provisionOpen = false">
                <div class="modal card sm">
                    <div class="modal-head">
                        <h3>Provision login</h3>
                        <button class="btn btn-ghost btn-icon" @click="provisionOpen = false">×</button>
                    </div>
                    <form class="modal-body" @submit.prevent="provision">
                        <p class="hint">
                            Creates a login for an employee. The username is the employee code and a
                            temporary password is generated — the employee must change it on first login.
                        </p>
                        <p v-if="provisionError" class="error">{{ provisionError }}</p>
                        <label class="field">
                            <span>Employee</span>
                            <SearchableSelect v-model="provisionForm.employee_id" :options="employeeOptions" placeholder="Search employee…" />
                        </label>
                        <label class="field">
                            <span>Role</span>
                            <select v-model="provisionForm.role" class="select">
                                <option v-for="r in roles" :key="r" :value="r">{{ r }}</option>
                            </select>
                        </label>
                        <div class="modal-actions">
                            <button type="button" class="btn btn-ghost" @click="provisionOpen = false">Cancel</button>
                            <button type="submit" class="btn btn-primary" :disabled="!provisionForm.employee_id">Provision</button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>

        <!-- One-time temp password reveal -->
        <transition name="fade">
            <div v-if="tempPassword" class="modal-backdrop" @click.self="tempPassword = ''">
                <div class="modal card sm">
                    <div class="modal-head">
                        <h3>Login created</h3>
                        <button class="btn btn-ghost btn-icon" @click="tempPassword = ''">×</button>
                    </div>
                    <div class="modal-body">
                        <p class="hint">Share this temporary password with <strong>{{ tempUsername }}</strong>. It won't be shown again.</p>
                        <div class="temp">
                            <code>{{ tempPassword }}</code>
                            <button class="btn btn-ghost btn-icon" @click="copyTemp" aria-label="Copy"><span v-html="copyIcon" /></button>
                        </div>
                        <p v-if="copied" class="copied">Copied to clipboard.</p>
                        <div class="modal-actions">
                            <button class="btn btn-primary" @click="tempPassword = ''">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </CrudTable>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import CrudTable from '../components/CrudTable.vue';
import SearchableSelect from '../components/SearchableSelect.vue';

const roles = ['admin', 'manager', 'deliveries', 'orders', 'warehouse', 'staff'];

const columns = [
    { key: 'name', label: 'Name' },
    { key: 'username', label: 'Username' },
    { key: 'role', label: 'Role' },
    { key: 'active', label: 'Active', format: (v) => (v ? 'Yes' : 'No') },
];

const employeeOptions = ref([]);

const fields = computed(() => [
    { key: 'name', label: 'Name' },
    { key: 'username', label: 'Username' },
    { key: 'password', label: 'Password', type: 'password' },
    { key: 'role', label: 'Role', default: 'staff', options: roles.map((r) => ({ value: r, label: r })) },
    { key: 'employee_id', label: 'Linked Employee', options: employeeOptions.value, searchable: true },
    { key: 'assign', label: 'Assignment' },
]);

const table = ref(null);
const provisionOpen = ref(false);
const provisionForm = reactive({ employee_id: '', role: 'staff' });
const provisionError = ref('');
const tempPassword = ref('');
const tempUsername = ref('');
const copied = ref(false);

function openProvision() {
    provisionForm.employee_id = '';
    provisionForm.role = 'staff';
    provisionError.value = '';
    provisionOpen.value = true;
}

async function provision() {
    provisionError.value = '';
    try {
        const { data } = await window.axios.post('/api/users/provision', { ...provisionForm });
        provisionOpen.value = false;
        tempUsername.value = data.user.username;
        tempPassword.value = data.temp_password;
        copied.value = false;
        table.value?.reload();
    } catch (e) {
        const errors = e.response?.data?.errors;
        provisionError.value = errors ? Object.values(errors)[0][0] : e.response?.data?.message || 'Could not provision login.';
    }
}

async function copyTemp() {
    try {
        await navigator.clipboard.writeText(tempPassword.value);
        copied.value = true;
    } catch { /* clipboard may be blocked; user can select manually */ }
}

onMounted(async () => {
    const { data } = await window.axios.get('/api/employees', { params: { per_page: 1000 } });
    const employees = data.data ?? data;
    employeeOptions.value = employees.map((e) => ({
        value: e.id,
        label: `${e.employee_code} — ${e.employee_name}`,
    }));
});

const keyIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>';
const copyIcon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
</script>

<style scoped>
.modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; padding: 1rem; z-index: 100; }
.modal.sm { width: 440px; max-width: 100%; }
.modal-head { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); }
.modal-body { padding: 1.25rem; display: flex; flex-direction: column; gap: 0.9rem; }
.field { display: flex; flex-direction: column; gap: 0.35rem; font-size: 0.82rem; font-weight: 550; color: var(--text-muted); }
.hint { margin: 0; font-size: 0.85rem; color: var(--text-muted); }
.modal-actions { display: flex; justify-content: flex-end; gap: 0.6rem; margin-top: 0.4rem; }
.error { color: var(--danger); background: var(--danger-soft); padding: 0.5rem 0.7rem; border-radius: var(--radius-sm); margin: 0; }
.temp { display: flex; align-items: center; gap: 0.5rem; background: var(--surface-2); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm); }
.temp code { font-size: 1rem; letter-spacing: 0.04em; flex: 1; }
.copied { margin: 0; font-size: 0.8rem; color: var(--text-muted); }
.fade-enter-active, .fade-leave-active { transition: opacity 0.15s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
